<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Announcement;
use App\Repositories\Contracts\AnnouncementRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class AnnouncementRepository implements AnnouncementRepositoryInterface
{
    /**
     * Get all announcements with pagination.
     */
    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Announcement::with('user')->latest()->paginate($perPage);
    }

    /**
     * Get public active announcements.
     */
    public function getActivePaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Announcement::with('user')->active()->latest()->paginate($perPage);
    }

    /**
     * Find announcement by ID.
     */
    public function findById(string $id): ?Announcement
    {
        return Announcement::find($id);
    }

    /**
     * Find announcement by Slug.
     */
    public function findBySlug(string $slug): ?Announcement
    {
        return Announcement::where('slug', $slug)->first();
    }

    /**
     * Create a new announcement.
     */
    public function create(array $data): Announcement
    {
        return Announcement::create($data);
    }

    /**
     * Update an existing announcement.
     */
    public function update(string $id, array $data): bool
    {
        $announcement = $this->findById($id);
        if (!$announcement) {
            return false;
        }

        return $announcement->update($data);
    }

    /**
     * Delete an announcement.
     */
    public function delete(string $id): bool
    {
        $announcement = $this->findById($id);
        if (!$announcement) {
            return false;
        }

        return (bool) $announcement->delete();
    }
}
