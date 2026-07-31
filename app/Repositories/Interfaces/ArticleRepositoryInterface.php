<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface
{
    public function getPaginated(int $perPage = 10, ?string $search = null): LengthAwarePaginator;
    public function findById(string $id): ?Article;
    public function create(array $data): Article;
    public function update(Article $article, array $data): bool;
    public function delete(Article $article): bool;
}
