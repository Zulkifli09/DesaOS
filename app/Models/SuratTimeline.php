<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SuratStatus;
use App\Enums\ApprovalStage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SuratTimeline extends Model
{
    use HasUuids;

    protected $fillable = [
        'surat_permohonan_id',
        'user_id',
        'status',
        'stage',
        'judul',
        'deskripsi',
        'catatan',
        'icon',
        'color',
    ];

    protected function casts(): array
    {
        return [
            'status' => SuratStatus::class,
        ];
    }

    public function suratPermohonan()
    {
        return $this->belongsTo(SuratPermohonan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
