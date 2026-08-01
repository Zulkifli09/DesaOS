<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceAnnouncement extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'judul',
        'isi',
        'tipe',
        'is_active',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected function casts(): array
    {
        return [
            'is_active'       => 'boolean',
            'tanggal_mulai'   => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('tanggal_mulai')
                  ->orWhere('tanggal_mulai', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('tanggal_selesai')
                  ->orWhere('tanggal_selesai', '>=', now());
            });
    }

    public function tipeClass(): string
    {
        return match($this->tipe) {
            'warning' => 'bg-yellow-50 border-yellow-300 text-yellow-800',
            'success' => 'bg-green-50 border-green-300 text-green-800',
            'danger'  => 'bg-red-50 border-red-300 text-red-800',
            default   => 'bg-blue-50 border-blue-300 text-blue-800',
        };
    }
}
