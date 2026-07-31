<?php

declare(strict_types=1);

namespace App\DTOs;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class AnnouncementDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $slug,
        public readonly string $content,
        public readonly string $type,
        public readonly bool $isActive,
        public readonly ?string $expiredAt,
        public readonly ?UploadedFile $attachment
    ) {
    }

    /**
     * Create a new DTO instance from an array of validated data.
     *
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            slug: Str::slug($data['title']),
            content: $data['content'],
            type: $data['type'],
            isActive: (bool) ($data['is_active'] ?? false),
            expiredAt: $data['expired_at'] ?? null,
            attachment: $data['attachment'] ?? null
        );
    }
}
