<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Umkm extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $table = 'umkms';

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'logo',
        'location',
        'maps_url',
        'whatsapp',
        'instagram',
        'operational_hours',
        'gallery_images',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'is_featured' => 'boolean',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
