<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\SuratPermohonan;
use Illuminate\Pagination\LengthAwarePaginator;

interface SuratRepositoryInterface
{
    public function getPaginatedByUser(string $userId, int $perPage = 10, ?string $status = null): LengthAwarePaginator;

    public function getPaginatedAll(int $perPage = 15, ?string $status = null, ?string $search = null): LengthAwarePaginator;

    public function findById(string $id): ?SuratPermohonan;

    public function findByNomor(string $nomor): ?SuratPermohonan;

    public function findByVerificationHash(string $hash): ?SuratPermohonan;

    public function create(array $data): SuratPermohonan;

    public function update(SuratPermohonan $surat, array $data): bool;

    public function delete(SuratPermohonan $surat): bool;

    public function countByStatus(string $userId = null): array;
}
