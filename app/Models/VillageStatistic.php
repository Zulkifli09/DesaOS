<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_population',
        'total_family',
        'total_dusun',
        'total_rt',
        'total_rw',
        'gender_data',
        'education_data',
        'job_data',
        'age_data',
        'religion_data',
    ];

    protected $casts = [
        'gender_data' => 'array',
        'education_data' => 'array',
        'job_data' => 'array',
        'age_data' => 'array',
        'religion_data' => 'array',
    ];
}
