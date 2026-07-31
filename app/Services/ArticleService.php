<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\ArticleDTO;
use App\Models\Article;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleService
{
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
        protected MediaService $mediaService
    ) {
    }

    public function getPaginatedArticles(int $perPage = 10, ?string $search = null)
    {
        return $this->articleRepository->getPaginated($perPage, $search);
    }

    public function createArticle(ArticleDTO $dto): Article
    {
        $data = $this->prepareData($dto);
        return $this->articleRepository->create($data);
    }

    public function updateArticle(Article $article, ArticleDTO $dto): bool
    {
        $data = $this->prepareData($dto, $article);
        return $this->articleRepository->update($article, $data);
    }

    public function deleteArticle(Article $article): bool
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        return $this->articleRepository->delete($article);
    }

    protected function prepareData(ArticleDTO $dto, ?Article $article = null): array
    {
        $data = [
            'title' => $dto->title,
            'slug' => Str::slug($dto->title),
            'content' => $dto->content,
            'status' => $dto->status,
            'category_id' => $dto->categoryId,
            'user_id' => $dto->userId,
        ];

        // Unique slug handling
        if (!$article || $article->title !== $dto->title) {
            $count = Article::where('slug', 'like', "{$data['slug']}%")->count();
            if ($count > 0) {
                $data['slug'] = $data['slug'] . '-' . uniqid();
            }
        }

        if ($dto->status === 'published' && (!$article || !$article->published_at)) {
            $data['published_at'] = now();
        }

        if ($dto->image) {
            if ($article && $article->image) {
                // In a real app we'd fetch the Media record, for now we just delete path
                Storage::disk('public')->delete($article->image);
            }
            $media = $this->mediaService->upload($dto->image, 'articles');
            $data['image'] = $media->path;
        }

        return $data;
    }
}
