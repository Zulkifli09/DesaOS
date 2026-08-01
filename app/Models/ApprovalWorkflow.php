<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ApprovalStage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ApprovalWorkflow extends Model
{
    use HasUuids;

    protected $fillable = [
        'surat_permohonan_id',
        'current_stage',
        'status',
        'is_completed',
    ];

    protected function casts(): array
    {
        return [
            'current_stage' => ApprovalStage::class,
            'is_completed'  => 'boolean',
        ];
    }

    public function suratPermohonan()
    {
        return $this->belongsTo(SuratPermohonan::class);
    }

    public function stages()
    {
        return $this->hasMany(ApprovalStageModel::class, 'approval_workflow_id')->orderBy('created_at');
    }
}
