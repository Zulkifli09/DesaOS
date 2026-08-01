<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\PengaduanDTO;
use App\Enums\PengaduanStatus;
use App\Models\Pengaduan;
use App\Models\PengaduanDokumen;
use App\Models\PengaduanKomentar;
use App\Models\PengaduanTimeline;
use App\Repositories\Interfaces\PengaduanRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengaduanService
{
    public function __construct(
        protected PengaduanRepositoryInterface $pengaduanRepository,
        protected NotificationService $notificationService,
    ) {}

    /**
     * Generate unique nomor pengaduan.
     * Format: ADU/{URUTAN}/{BULAN}/{TAHUN}
     */
    public function generateNomor(): string
    {
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('Y');
        $count = Pengaduan::whereYear('created_at', $tahun)->whereMonth('created_at', $bulan)->count();
        $urutan = str_pad((string) ($count + 1), 4, '0', STR_PAD_LEFT);
        return "ADU/{$urutan}/{$bulan}/{$tahun}";
    }

    /**
     * Create a new pengaduan.
     */
    public function create(PengaduanDTO $dto): Pengaduan
    {
        return DB::transaction(function () use ($dto) {
            $nomor = $this->generateNomor();

            $pengaduan = $this->pengaduanRepository->create([
                'nomor_pengaduan'  => $nomor,
                'user_id'          => $dto->userId,
                'kategori'         => $dto->kategori->value,
                'prioritas'        => $dto->prioritas->value,
                'status'           => PengaduanStatus::Menunggu->value,
                'judul'            => $dto->judul,
                'deskripsi'        => $dto->deskripsi,
                'lokasi'           => $dto->lokasi,
                'lat'              => $dto->lat,
                'lng'              => $dto->lng,
                'tanggal_pengaduan'=> now()->toDateString(),
                'estimasi_selesai' => now()->addDays(7)->toDateString(),
            ]);

            $this->addTimeline($pengaduan, PengaduanStatus::Menunggu,
                'Pengaduan Diterima',
                "Pengaduan #{$nomor} telah berhasil dikirim dan sedang menunggu penanganan."
            );

            $this->notificationService->notifyPengaduanStatus($pengaduan, PengaduanStatus::Menunggu);

            return $pengaduan;
        });
    }

    /**
     * Upload attachment for pengaduan.
     */
    public function uploadDokumen(Pengaduan $pengaduan, UploadedFile $file, ?string $keterangan = null): PengaduanDokumen
    {
        $path = $file->store("pengaduan/dokumen/{$pengaduan->id}", 'public');

        return PengaduanDokumen::create([
            'pengaduan_id' => $pengaduan->id,
            'file_path'    => $path,
            'file_name'    => $file->getClientOriginalName(),
            'mime_type'    => $file->getMimeType(),
            'file_size'    => $file->getSize(),
            'keterangan'   => $keterangan,
        ]);
    }

    /**
     * Update status of a pengaduan (admin action).
     */
    public function updateStatus(
        Pengaduan $pengaduan,
        PengaduanStatus $newStatus,
        string $judul,
        ?string $deskripsi = null,
        ?string $catatanPetugas = null,
        ?string $catatanPenolakan = null,
        ?string $petugasId = null,
    ): bool {
        return DB::transaction(function () use ($pengaduan, $newStatus, $judul, $deskripsi, $catatanPetugas, $catatanPenolakan, $petugasId) {
            $updateData = ['status' => $newStatus->value];

            if ($catatanPetugas) {
                $updateData['catatan_petugas'] = $catatanPetugas;
            }

            if ($catatanPenolakan) {
                $updateData['catatan_penolakan'] = $catatanPenolakan;
            }

            if ($petugasId) {
                $updateData['petugas_id'] = $petugasId;
            }

            if ($newStatus === PengaduanStatus::Selesai) {
                $updateData['tanggal_selesai'] = now()->toDateString();
            }

            $result = $this->pengaduanRepository->update($pengaduan, $updateData);

            if ($result) {
                $this->addTimeline($pengaduan, $newStatus, $judul, $deskripsi);
                $this->notificationService->notifyPengaduanStatus($pengaduan->fresh(), $newStatus);
            }

            return $result;
        });
    }

    /**
     * Add a comment to a pengaduan.
     */
    public function addKomentar(Pengaduan $pengaduan, string $userId, string $komentar, bool $isInternal = false): PengaduanKomentar
    {
        return PengaduanKomentar::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id'      => $userId,
            'komentar'     => $komentar,
            'is_internal'  => $isInternal,
        ]);
    }

    /**
     * Add a timeline entry.
     */
    public function addTimeline(
        Pengaduan $pengaduan,
        PengaduanStatus $status,
        string $judul,
        ?string $deskripsi = null,
        ?string $catatan = null,
    ): PengaduanTimeline {
        return PengaduanTimeline::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id'      => auth()->id(),
            'status'       => $status->value,
            'judul'        => $judul,
            'deskripsi'    => $deskripsi,
            'catatan'      => $catatan,
            'icon'         => 'chat-bubble',
            'color'        => $status->color(),
        ]);
    }

    public function getPaginatedByUser(string $userId, int $perPage = 10, ?string $status = null)
    {
        return $this->pengaduanRepository->getPaginatedByUser($userId, $perPage, $status);
    }

    public function getPaginatedAll(int $perPage = 15, ?string $status = null, ?string $search = null)
    {
        return $this->pengaduanRepository->getPaginatedAll($perPage, $status, $search);
    }

    public function findById(string $id): ?Pengaduan
    {
        return $this->pengaduanRepository->findById($id);
    }

    public function getStatsByUser(string $userId): array
    {
        return $this->pengaduanRepository->countByStatus($userId);
    }

    public function getStatsAll(): array
    {
        return $this->pengaduanRepository->countByStatus();
    }
}
