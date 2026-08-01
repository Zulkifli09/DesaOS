<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\ApprovalStage;
use App\Enums\SuratStatus;
use App\Models\ApprovalWorkflow;
use App\Models\ApprovalStageModel;
use App\Models\SuratPermohonan;
use Illuminate\Support\Facades\DB;

class ApprovalService
{
    public function __construct(
        protected SuratService $suratService,
    ) {}

    /**
     * Process an approval action at the current stage.
     *
     * @param string $action  'approved' | 'rejected' | 'revision'
     */
    public function processAction(
        ApprovalWorkflow $workflow,
        string $action,
        string $approverId,
        ?string $catatan = null,
    ): bool {
        return DB::transaction(function () use ($workflow, $action, $approverId, $catatan) {
            $surat = $workflow->suratPermohonan;
            $currentStage = $workflow->current_stage;

            // Record the stage action
            ApprovalStageModel::create([
                'approval_workflow_id' => $workflow->id,
                'user_id'              => $approverId,
                'stage'                => $currentStage->value,
                'action'               => $action,
                'catatan'              => $catatan,
                'actioned_at'          => now(),
            ]);

            if ($action === 'rejected') {
                return $this->handleRejection($workflow, $surat, $catatan);
            }

            if ($action === 'revision') {
                return $this->handleRevision($workflow, $surat, $catatan);
            }

            // Approved — check if there's a next stage
            $nextStage = $this->getNextStage($currentStage);

            if ($nextStage) {
                return $this->advanceToNextStage($workflow, $surat, $nextStage, $catatan);
            }

            // Final stage approved — complete the surat
            return $this->completeSurat($workflow, $surat);
        });
    }

    /**
     * Get the next approval stage, or null if we're at the last stage.
     */
    private function getNextStage(ApprovalStage $current): ?ApprovalStage
    {
        return match($current) {
            ApprovalStage::Operator => ApprovalStage::Kasi,
            ApprovalStage::Kasi     => ApprovalStage::Sekdes,
            ApprovalStage::Sekdes   => ApprovalStage::KepDes,
            ApprovalStage::KepDes   => null,
        };
    }

    /**
     * Advance workflow to the next stage.
     */
    private function advanceToNextStage(
        ApprovalWorkflow $workflow,
        SuratPermohonan $surat,
        ApprovalStage $nextStage,
        ?string $catatan
    ): bool {
        $workflow->update([
            'current_stage' => $nextStage->value,
            'status'        => 'pending',
        ]);

        $newStatus = $nextStage === ApprovalStage::KepDes
            ? SuratStatus::MenungguPersetujuan
            : SuratStatus::Diproses;

        $this->suratService->updateStatus(
            $surat,
            $newStatus,
            "Disetujui oleh " . $workflow->current_stage?->label(),
            "Permohonan diteruskan ke " . $nextStage->label(),
            $catatan,
        );

        return true;
    }

    /**
     * Handle rejection — stop the workflow.
     */
    private function handleRejection(ApprovalWorkflow $workflow, SuratPermohonan $surat, ?string $catatan): bool
    {
        $workflow->update(['status' => 'rejected', 'is_completed' => true]);

        $this->suratService->updateStatus(
            $surat,
            SuratStatus::Ditolak,
            "Permohonan Ditolak",
            "Permohonan ditolak oleh " . $workflow->current_stage?->label(),
            null,
            $catatan,
        );

        return true;
    }

    /**
     * Handle revision request.
     */
    private function handleRevision(ApprovalWorkflow $workflow, SuratPermohonan $surat, ?string $catatan): bool
    {
        $this->suratService->updateStatus(
            $surat,
            SuratStatus::Revisi,
            "Perlu Revisi",
            "Permohonan memerlukan revisi dari pemohon.",
            $catatan,
        );

        return true;
    }

    /**
     * Complete the surat after final approval.
     */
    private function completeSurat(ApprovalWorkflow $workflow, SuratPermohonan $surat): bool
    {
        $workflow->update(['status' => 'approved', 'is_completed' => true]);

        $this->suratService->updateStatus(
            $surat,
            SuratStatus::Selesai,
            "Surat Selesai",
            "Permohonan telah disetujui oleh semua pihak dan surat telah diterbitkan.",
        );

        return true;
    }

    /**
     * Get pending approvals for a user based on their role stage.
     */
    public function getPendingForStage(ApprovalStage $stage, int $perPage = 15)
    {
        return ApprovalWorkflow::with(['suratPermohonan.user', 'suratPermohonan.template'])
            ->where('current_stage', $stage->value)
            ->where('status', 'pending')
            ->where('is_completed', false)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get approval workflow for a surat.
     */
    public function getWorkflowForSurat(string $suratId): ?ApprovalWorkflow
    {
        return ApprovalWorkflow::with(['stages.user'])->where('surat_permohonan_id', $suratId)->first();
    }
}
