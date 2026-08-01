<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\JenisSurat;
use App\Enums\SuratStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SuratPermohonan extends Model
{
    use HasUuids;
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'nomor_surat',
        'surat_template_id',
        'user_id',
        'jenis_surat',
        'status',
        'nama_pemohon',
        'nik_pemohon',
        'alamat_pemohon',
        'no_hp_pemohon',
        'keperluan',
        'data_tambahan',
        'catatan_pemohon',
        'catatan_operator',
        'catatan_penolakan',
        'qr_code',
        'verification_hash',
        'verification_url',
        'pdf_path',
        'current_stage',
        'tanggal_pengajuan',
        'tanggal_selesai',
        'estimasi_selesai',
    ];

    protected function casts(): array
    {
        return [
            'jenis_surat'      => JenisSurat::class,
            'status'           => SuratStatus::class,
            'data_tambahan'    => 'array',
            'tanggal_pengajuan'=> 'date',
            'tanggal_selesai'  => 'date',
            'estimasi_selesai' => 'date',
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
    public function template()
    {
        return $this->belongsTo(SuratTemplate::class, 'surat_template_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dokumens()
    {
        return $this->hasMany(SuratDokumen::class);
    }

    public function timelines()
    {
        return $this->hasMany(SuratTimeline::class)->orderBy('created_at', 'asc');
    }

    public function approvalWorkflow()
    {
        return $this->hasOne(ApprovalWorkflow::class);
    }

    public function verifikasiLogs()
    {
        return $this->hasMany(SuratVerifikasiLog::class);
    }

    // Scopes
    public function scopeByUser($query, string $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', SuratStatus::activeStatuses());
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', SuratStatus::Selesai);
    }

    // Helpers
    public function isEditable(): bool
    {
        return $this->status === SuratStatus::Draft;
    }

    public function isVerified(): bool
    {
        return $this->status === SuratStatus::Selesai;
    }

    public function progressPercent(): int
    {
        if ($this->status === SuratStatus::Ditolak) {
            return 0;
        }
        return min(100, ($this->status->stepNumber() / 6) * 100);
    }
}
