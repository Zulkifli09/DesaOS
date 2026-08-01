<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PengaduanDokumen extends Model
{
    use HasUuids;

    protected $fillable = [
        'pengaduan_id',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
        ];
    }

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
}
