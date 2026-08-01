<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\SuratStatus;
use App\Http\Controllers\Controller;
use App\Models\SuratPermohonan;
use App\Services\SuratService;
use App\Services\ApprovalService;
use Illuminate\Http\Request;

class SuratAdminController extends Controller
{
    public function __construct(
        protected SuratService $suratService,
        protected ApprovalService $approvalService,
    ) {}

    public function index(Request $request)
    {
        $surats = $this->suratService->getPaginatedAll(
            15,
            $request->status,
            $request->search
        );
        $stats     = $this->suratService->getStatsAll();
        $statuses  = SuratStatus::cases();

        return view('admin.surat.index', compact('surats', 'stats', 'statuses'));
    }

    public function show(SuratPermohonan $surat)
    {
        $surat->load(['template', 'user', 'dokumens', 'timelines.user', 'approvalWorkflow.stages.user']);
        $workflow = $this->approvalService->getWorkflowForSurat($surat->id);

        return view('admin.surat.show', compact('surat', 'workflow'));
    }

    /**
     * Process approval action — approve, reject, or request revision.
     */
    public function processApproval(Request $request, SuratPermohonan $surat)
    {
        $request->validate([
            'action'  => 'required|in:approved,rejected,revision',
            'catatan' => 'nullable|string|max:1000',
        ]);

        $workflow = $surat->approvalWorkflow;
        abort_if(!$workflow, 404, 'Workflow tidak ditemukan.');

        $this->approvalService->processAction(
            $workflow,
            $request->action,
            auth()->id(),
            $request->catatan,
        );

        $actionLabel = match($request->action) {
            'approved' => 'disetujui',
            'rejected' => 'ditolak',
            'revision' => 'dikembalikan untuk revisi',
        };

        return redirect()
            ->route('admin.surat.show', $surat->id)
            ->with('success', "Permohonan berhasil {$actionLabel}.");
    }
}
