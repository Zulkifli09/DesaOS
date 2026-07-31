<?php

declare(strict_types=1);

namespace App\DTOs;

class ArticleDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $content,
        public readonly ?string $status,
        public readonly ?string $categoryId,
        public readonly string $userId,
        public readonly mixed $image = null,
        public readonly ?string $publishedAt = null
    ) {
    }

    public static function fromRequest(array $data, string $userId, mixed $image = null): self
    {
        return new self(
            title: $data['title'],
            content: $data['content'],
            status: $data['status'] ?? 'draft',
            categoryId: $data['category_id'] ?? null,
            userId: $userId,
            image: $image,
            publishedAt: $data['published_at'] ?? null,
        );
    }
}
