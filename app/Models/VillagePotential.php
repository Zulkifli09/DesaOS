<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VillagePotential extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'category',
        'name',
        'slug',
        'description',
        'cover_image',
        'location',
        'contact_name',
        'contact_phone',
        'gallery_images',
        'status',
    ];

    protected $casts = [
        'gallery_images' => 'array',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
