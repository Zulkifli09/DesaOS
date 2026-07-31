<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Announcement;
use Illuminate\Pagination\LengthAwarePaginator;

interface AnnouncementRepositoryInterface
{
    /**
     * Get all announcements with pagination.
     */
    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator;

    /**
     * Get public active announcements.
     */
    public function getActivePaginated(int $perPage = 10): LengthAwarePaginator;

    /**
     * Find announcement by ID.
     */
    public function findById(string $id): ?Announcement;

    /**
     * Find announcement by Slug.
     */
    public function findBySlug(string $slug): ?Announcement;

    /**
     * Create a new announcement.
     */
    public function create(array $data): Announcement;

    /**
     * Update an existing announcement.
     */
    public function update(string $id, array $data): bool;

    /**
     * Delete an announcement.
     */
    public function delete(string $id): bool;
}
