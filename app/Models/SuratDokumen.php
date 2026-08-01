<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SuratDokumen extends Model
{
    use HasUuids;

    protected $fillable = [
        'surat_permohonan_id',
        'nama_dokumen',
        'jenis_dokumen',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
        'is_verified',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'file_size'   => 'integer',
        ];
    }

    public function suratPermohonan()
    {
        return $this->belongsTo(SuratPermohonan::class);
    }
}
