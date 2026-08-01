<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\SuratPermohonan;
use App\Repositories\Interfaces\SuratRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class SuratRepository implements SuratRepositoryInterface
{
    public function getPaginatedByUser(string $userId, int $perPage = 10, ?string $status = null): LengthAwarePaginator
    {
        return SuratPermohonan::with(['template', 'timelines'])
            ->where('user_id', $userId)
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate($perPage);
    }

    public function getPaginatedAll(int $perPage = 15, ?string $status = null, ?string $search = null): LengthAwarePaginator
    {
        return SuratPermohonan::with(['user', 'template'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($search, fn ($q) => $q->where(function ($query) use ($search) {
                $query->where('nomor_surat', 'like', "%{$search}%")
                      ->orWhere('nama_pemohon', 'like', "%{$search}%")
                      ->orWhere('nik_pemohon', 'like', "%{$search}%");
            }))
            ->latest()
            ->paginate($perPage);
    }

    public function findById(string $id): ?SuratPermohonan
    {
        return SuratPermohonan::with(['template', 'user', 'dokumens', 'timelines.user', 'approvalWorkflow.stages.user'])
            ->find($id);
    }

    public function findByNomor(string $nomor): ?SuratPermohonan
    {
        return SuratPermohonan::where('nomor_surat', $nomor)->first();
    }

    public function findByVerificationHash(string $hash): ?SuratPermohonan
    {
        return SuratPermohonan::with(['template', 'user'])
            ->where('verification_hash', $hash)
            ->first();
    }

    public function create(array $data): SuratPermohonan
    {
        return SuratPermohonan::create($data);
    }

    public function update(SuratPermohonan $surat, array $data): bool
    {
        return $surat->update($data);
    }

    public function delete(SuratPermohonan $surat): bool
    {
        return (bool) $surat->delete();
    }

    public function countByStatus(string $userId = null): array
    {
        $query = SuratPermohonan::query();
        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
    }
}
