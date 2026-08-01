<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Pengaduan;
use Illuminate\Pagination\LengthAwarePaginator;

interface PengaduanRepositoryInterface
{
    public function getPaginatedByUser(string $userId, int $perPage = 10, ?string $status = null): LengthAwarePaginator;

    public function getPaginatedAll(int $perPage = 15, ?string $status = null, ?string $search = null): LengthAwarePaginator;

    public function findById(string $id): ?Pengaduan;

    public function findByNomor(string $nomor): ?Pengaduan;

    public function create(array $data): Pengaduan;

    public function update(Pengaduan $pengaduan, array $data): bool;

    public function delete(Pengaduan $pengaduan): bool;

    public function countByStatus(string $userId = null): array;
}
