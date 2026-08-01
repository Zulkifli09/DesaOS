<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SuratVerifikasiLog extends Model
{
    use HasUuids;

    protected $fillable = [
        'surat_permohonan_id',
        'verification_hash',
        'ip_address',
        'user_agent',
        'is_valid',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'is_valid' => 'boolean',
        ];
    }

    public function suratPermohonan()
    {
        return $this->belongsTo(SuratPermohonan::class);
    }
}
