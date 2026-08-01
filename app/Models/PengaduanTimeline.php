<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PengaduanStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PengaduanTimeline extends Model
{
    use HasUuids;

    protected $fillable = [
        'pengaduan_id',
        'user_id',
        'status',
        'judul',
        'deskripsi',
        'catatan',
        'icon',
        'color',
    ];

    protected function casts(): array
    {
        return [
            'status' => PengaduanStatus::class,
        ];
    }

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
