<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\JenisSurat;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratTemplate extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'jenis_surat',
        'nama',
        'deskripsi',
        'persyaratan',
        'fields_config',
        'template_pdf',
        'estimasi_hari',
        'is_active',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'jenis_surat'   => JenisSurat::class,
            'persyaratan'   => 'array',
            'fields_config' => 'array',
            'is_active'     => 'boolean',
            'estimasi_hari' => 'integer',
            'urutan'        => 'integer',
        ];
    }

    public function suratPermohonan()
    {
        return $this->hasMany(SuratPermohonan::class, 'surat_template_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }
}
