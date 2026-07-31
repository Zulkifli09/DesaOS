<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MediaService
{
    protected string $disk;
    protected ImageManager $imageManager;

    public function __construct()
    {
        $this->disk = config('filesystems.default', 'public');
        $this->imageManager = new ImageManager(new Driver());
    }

    public function upload(UploadedFile $file, string $directory = 'media'): Media
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::uuid() . '.' . $extension;
        $mimeType = $file->getMimeType();
        $size = $file->getSize();

        $path = "{$directory}/{$fileName}";

        // Optimize image if it's an image
        if (str_starts_with($mimeType, 'image/')) {
            $image = $this->imageManager->read($file->getRealPath());

            // Resize if width is larger than 1200px
            if ($image->width() > 1200) {
                $image->scale(width: 1200);
            }

            // Encode to webp format (80% quality)
            $encoded = $image->toWebp(80);
            $fileName = Str::uuid() . '.webp';
            $path = "{$directory}/{$fileName}";
            $mimeType = 'image/webp';
            $size = strlen($encoded->toString());

            Storage::disk($this->disk)->put($path, $encoded->toString());
        } else {
            // Non-image file, just upload
            Storage::disk($this->disk)->put($path, file_get_contents($file->getRealPath()));
        }

        // Save to Database
        return Media::create([
            'file_name' => $file->getClientOriginalName(),
            'mime_type' => $mimeType,
            'size' => $size,
            'path' => $path,
            'disk' => $this->disk,
        ]);
    }

    public function delete(Media $media): bool
    {
        if (Storage::disk($media->disk)->exists($media->path)) {
            Storage::disk($media->disk)->delete($media->path);
        }

        return $media->delete();
    }
}
