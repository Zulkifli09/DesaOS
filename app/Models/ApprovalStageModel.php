<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ApprovalStage;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ApprovalStageModel extends Model
{
    use HasUuids;

    protected $table = 'approval_stages';

    protected $fillable = [
        'approval_workflow_id',
        'user_id',
        'stage',
        'action',
        'catatan',
        'actioned_at',
    ];

    protected function casts(): array
    {
        return [
            'stage'       => ApprovalStage::class,
            'actioned_at' => 'datetime',
        ];
    }

    public function workflow()
    {
        return $this->belongsTo(ApprovalWorkflow::class, 'approval_workflow_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
