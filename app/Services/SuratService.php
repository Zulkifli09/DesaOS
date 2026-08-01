<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\SuratDTO;
use App\Enums\SuratStatus;
use App\Enums\ApprovalStage;
use App\Models\SuratPermohonan;
use App\Models\SuratDokumen;
use App\Models\SuratTimeline;
use App\Models\ApprovalWorkflow;
use App\Repositories\Interfaces\SuratRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuratService
{
    public function __construct(
        protected SuratRepositoryInterface $suratRepository,
        protected QrCodeService $qrCodeService,
        protected NotificationService $notificationService,
    ) {}

    /**
     * Generate a unique nomor surat.
     * Format: {PREFIX}/{URUTAN}/{BULAN}/{TAHUN}
     */
    public function generateNomorSurat(string $prefix): string
    {
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('Y');

        $lastNumber = SuratPermohonan::where('nomor_surat', 'like', "{$prefix}/%/{$bulan}/{$tahun}")
            ->count();

        $urutan = str_pad((string) ($lastNumber + 1), 3, '0', STR_PAD_LEFT);

        return "{$prefix}/{$urutan}/{$bulan}/{$tahun}";
    }

    /**
     * Create a new surat draft.
     */
    public function createDraft(SuratDTO $dto): SuratPermohonan
    {
        return DB::transaction(function () use ($dto) {
            $surat = $this->suratRepository->create([
                'jenis_surat'      => $dto->jenisSurat->value,
                'surat_template_id'=> $dto->suratTemplateId,
                'user_id'          => $dto->userId,
                'status'           => SuratStatus::Draft->value,
                'nama_pemohon'     => $dto->namaPemohon,
                'nik_pemohon'      => $dto->nikPemohon,
                'alamat_pemohon'   => $dto->alamatPemohon,
                'no_hp_pemohon'    => $dto->noHpPemohon,
                'keperluan'        => $dto->keperluan,
                'data_tambahan'    => $dto->dataTambahan,
                'catatan_pemohon'  => $dto->catatanPemohon,
                'tanggal_pengajuan'=> now()->toDateString(),
                'estimasi_selesai' => now()->addDays($dto->jenisSurat->estimasiHari())->toDateString(),
            ]);

            $this->addTimeline($surat, SuratStatus::Draft, 'Permohonan Dibuat', 'Permohonan surat berhasil dibuat sebagai draft.');

            return $surat;
        });
    }

    /**
     * Submit draft — changes status to 'diajukan' and generates nomor surat.
     */
    public function submitSurat(SuratPermohonan $surat): SuratPermohonan
    {
        return DB::transaction(function () use ($surat) {
            $nomorSurat = $this->generateNomorSurat($surat->jenis_surat->kodePrefix());

            // Generate verification hash
            $hash = $this->qrCodeService->generateHash($surat->id, $nomorSurat);
            $verificationUrl = route('verifikasi.show', ['hash' => $hash]);

            $this->suratRepository->update($surat, [
                'status'           => SuratStatus::Diajukan->value,
                'nomor_surat'      => $nomorSurat,
                'verification_hash'=> $hash,
                'verification_url' => $verificationUrl,
                'current_stage'    => ApprovalStage::Operator->value,
            ]);

            // Create approval workflow
            ApprovalWorkflow::create([
                'surat_permohonan_id' => $surat->id,
                'current_stage'       => ApprovalStage::Operator->value,
                'status'              => 'pending',
            ]);

            $this->addTimeline($surat, SuratStatus::Diajukan, 'Permohonan Diajukan',
                "Permohonan dengan nomor {$nomorSurat} telah diajukan dan menunggu verifikasi operator.");

            $this->notificationService->notifySuratStatus($surat->fresh(), SuratStatus::Diajukan);

            return $surat->fresh();
        });
    }

    /**
     * Upload supporting documents for a surat.
     */
    public function uploadDokumen(SuratPermohonan $surat, UploadedFile $file, string $jenisDokumen, string $namaDokumen): SuratDokumen
    {
        $path = $file->store("surat/dokumen/{$surat->id}", 'public');

        return SuratDokumen::create([
            'surat_permohonan_id' => $surat->id,
            'nama_dokumen'        => $namaDokumen,
            'jenis_dokumen'       => $jenisDokumen,
            'file_path'           => $path,
            'file_name'           => $file->getClientOriginalName(),
            'mime_type'           => $file->getMimeType(),
            'file_size'           => $file->getSize(),
        ]);
    }

    /**
     * Update surat status (used by approval workflow).
     */
    public function updateStatus(
        SuratPermohonan $surat,
        SuratStatus $newStatus,
        string $judul,
        ?string $deskripsi = null,
        ?string $catatanOperator = null,
        ?string $catatanPenolakan = null,
    ): bool {
        return DB::transaction(function () use ($surat, $newStatus, $judul, $deskripsi, $catatanOperator, $catatanPenolakan) {
            $updateData = ['status' => $newStatus->value];

            if ($catatanOperator) {
                $updateData['catatan_operator'] = $catatanOperator;
            }

            if ($catatanPenolakan) {
                $updateData['catatan_penolakan'] = $catatanPenolakan;
            }

            if ($newStatus === SuratStatus::Selesai) {
                $updateData['tanggal_selesai'] = now()->toDateString();
                // Generate QR code image when surat is done
                $qrPath = $this->qrCodeService->generateQrImage($surat->verification_url, $surat->id);
                $updateData['qr_code'] = $qrPath;
            }

            $result = $this->suratRepository->update($surat, $updateData);

            if ($result) {
                $this->addTimeline($surat, $newStatus, $judul, $deskripsi);
                $this->notificationService->notifySuratStatus($surat->fresh(), $newStatus);
            }

            return $result;
        });
    }

    /**
     * Add a timeline entry for a surat.
     */
    public function addTimeline(
        SuratPermohonan $surat,
        SuratStatus $status,
        string $judul,
        ?string $deskripsi = null,
        ?string $catatan = null
    ): SuratTimeline {
        return SuratTimeline::create([
            'surat_permohonan_id' => $surat->id,
            'user_id'             => auth()->id(),
            'status'              => $status->value,
            'judul'               => $judul,
            'deskripsi'           => $deskripsi,
            'catatan'             => $catatan,
            'icon'                => $status->icon(),
            'color'               => $status->color(),
        ]);
    }

    /**
     * Delete a draft surat and its documents.
     */
    public function deleteDraft(SuratPermohonan $surat): bool
    {
        if (!$surat->isEditable()) {
            return false;
        }

        // Delete uploaded files
        foreach ($surat->dokumens as $dokumen) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        return $this->suratRepository->delete($surat);
    }

    public function getPaginatedByUser(string $userId, int $perPage = 10, ?string $status = null)
    {
        return $this->suratRepository->getPaginatedByUser($userId, $perPage, $status);
    }

    public function getPaginatedAll(int $perPage = 15, ?string $status = null, ?string $search = null)
    {
        return $this->suratRepository->getPaginatedAll($perPage, $status, $search);
    }

    public function findById(string $id): ?SuratPermohonan
    {
        return $this->suratRepository->findById($id);
    }

    public function findByVerificationHash(string $hash): ?SuratPermohonan
    {
        return $this->suratRepository->findByVerificationHash($hash);
    }

    public function getStatsByUser(string $userId): array
    {
        return $this->suratRepository->countByStatus($userId);
    }

    public function getStatsAll(): array
    {
        return $this->suratRepository->countByStatus();
    }
}
