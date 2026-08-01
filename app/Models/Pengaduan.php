<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PengaduanKategori;
use App\Enums\PengaduanPrioritas;
use App\Enums\PengaduanStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Pengaduan extends Model
{
    use HasUuids;
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'nomor_pengaduan',
        'user_id',
        'petugas_id',
        'kategori',
        'prioritas',
        'status',
        'judul',
        'deskripsi',
        'lokasi',
        'lat',
        'lng',
        'catatan_petugas',
        'catatan_penolakan',
        'tanggal_pengaduan',
        'tanggal_selesai',
        'estimasi_selesai',
    ];

    protected function casts(): array
    {
        return [
            'kategori'         => PengaduanKategori::class,
            'prioritas'        => PengaduanPrioritas::class,
            'status'           => PengaduanStatus::class,
            'tanggal_pengaduan'=> 'date',
            'tanggal_selesai'  => 'date',
            'estimasi_selesai' => 'date',
            'lat'              => 'decimal:7',
            'lng'              => 'decimal:7',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function komentars()
    {
        return $this->hasMany(PengaduanKomentar::class)->orderBy('created_at');
    }

    public function publicKomentars()
    {
        return $this->hasMany(PengaduanKomentar::class)->where('is_internal', false)->orderBy('created_at');
    }

    public function dokumens()
    {
        return $this->hasMany(PengaduanDokumen::class);
    }

    public function timelines()
    {
        return $this->hasMany(PengaduanTimeline::class)->orderBy('created_at');
    }

    // Scopes
    public function scopeByUser($query, string $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', [PengaduanStatus::Selesai->value, PengaduanStatus::Ditolak->value]);
    }

    // Helpers
    public function progressPercent(): int
    {
        return match($this->status) {
            PengaduanStatus::Menunggu   => 10,
            PengaduanStatus::Diproses   => 40,
            PengaduanStatus::Diteruskan => 70,
            PengaduanStatus::Selesai    => 100,
            PengaduanStatus::Ditolak    => 0,
        };
    }
}
