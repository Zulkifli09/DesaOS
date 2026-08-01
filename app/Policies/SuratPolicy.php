<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\SuratStatus;
use App\Models\SuratPermohonan;
use App\Models\User;

class SuratPolicy
{
    /**
     * Citizen can only view their own surat.
     * Staff/admin can view all.
     */
    public function view(User $user, SuratPermohonan $surat): bool
    {
        return $user->id === $surat->user_id
            || $user->hasAnyRole(['super_admin', 'kepala_desa', 'sekretaris_desa', 'kasi', 'operator']);
    }

    /**
     * Only the owner can update a draft surat.
     */
    public function update(User $user, SuratPermohonan $surat): bool
    {
        return $user->id === $surat->user_id && $surat->status === SuratStatus::Draft;
    }

    /**
     * Only the owner can delete a draft surat.
     */
    public function delete(User $user, SuratPermohonan $surat): bool
    {
        return $user->id === $surat->user_id && $surat->status === SuratStatus::Draft;
    }

    /**
     * Only staff can approve/reject surat.
     */
    public function approve(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'kepala_desa', 'sekretaris_desa', 'kasi', 'operator']);
    }
}
