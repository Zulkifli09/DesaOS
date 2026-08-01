<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Pengaduan;
use App\Models\User;

class PengaduanPolicy
{
    /**
     * Citizen can view their own pengaduan.
     * Staff/admin can view all.
     */
    public function view(User $user, Pengaduan $pengaduan): bool
    {
        return $user->id === $pengaduan->user_id
            || $user->hasAnyRole(['super_admin', 'kepala_desa', 'sekretaris_desa', 'kasi', 'operator', 'petugas_pelayanan']);
    }

    /**
     * Only the owner can update/delete their own pengaduan.
     */
    public function update(User $user, Pengaduan $pengaduan): bool
    {
        return $user->id === $pengaduan->user_id
            && $pengaduan->status->value === 'menunggu';
    }

    public function delete(User $user, Pengaduan $pengaduan): bool
    {
        return $user->id === $pengaduan->user_id
            && $pengaduan->status->value === 'menunggu';
    }

    /**
     * Only staff can process/update status of pengaduan.
     */
    public function process(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'kepala_desa', 'kasi', 'operator', 'petugas_pelayanan']);
    }
}
