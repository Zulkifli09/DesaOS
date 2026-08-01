<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Pengaduan;
use App\Repositories\Interfaces\PengaduanRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PengaduanRepository implements PengaduanRepositoryInterface
{
    public function getPaginatedByUser(string $userId, int $perPage = 10, ?string $status = null): LengthAwarePaginator
    {
        return Pengaduan::with(['timelines'])
            ->where('user_id', $userId)
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate($perPage);
    }

    public function getPaginatedAll(int $perPage = 15, ?string $status = null, ?string $search = null): LengthAwarePaginator
    {
        return Pengaduan::with(['user', 'petugas'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($search, fn ($q) => $q->where(function ($query) use ($search) {
                $query->where('nomor_pengaduan', 'like', "%{$search}%")
                      ->orWhere('judul', 'like', "%{$search}%")
                      ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            }))
            ->latest()
            ->paginate($perPage);
    }

    public function findById(string $id): ?Pengaduan
    {
        return Pengaduan::with([
            'user',
            'petugas',
            'dokumens',
            'publicKomentars.user',
            'timelines.user',
        ])->find($id);
    }

    public function findByNomor(string $nomor): ?Pengaduan
    {
        return Pengaduan::where('nomor_pengaduan', $nomor)->first();
    }

    public function create(array $data): Pengaduan
    {
        return Pengaduan::create($data);
    }

    public function update(Pengaduan $pengaduan, array $data): bool
    {
        return $pengaduan->update($data);
    }

    public function delete(Pengaduan $pengaduan): bool
    {
        return (bool) $pengaduan->delete();
    }

    public function countByStatus(string $userId = null): array
    {
        $query = Pengaduan::query();
        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
    }
}
