<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\AnnouncementDTO;
use App\Models\Announcement;
use App\Repositories\Contracts\AnnouncementRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Exception;

class AnnouncementService
{
    public function __construct(
        private readonly AnnouncementRepositoryInterface $repository
    ) {
    }

    public function createAnnouncement(AnnouncementDTO $dto, string $userId): Announcement
    {
        $data = [
            'title' => $dto->title,
            'slug' => $dto->slug,
            'content' => $dto->content,
            'type' => $dto->type,
            'is_active' => $dto->isActive,
            'expired_at' => $dto->expiredAt,
            'user_id' => $userId,
        ];

        if ($dto->attachment) {
            $data['attachment'] = $dto->attachment->store('announcements', 'public');
        }

        return $this->repository->create($data);
    }

    public function updateAnnouncement(string $id, AnnouncementDTO $dto): bool
    {
        $announcement = $this->repository->findById($id);
        if (!$announcement) {
            return false;
        }

        $data = [
            'title' => $dto->title,
            'slug' => $dto->slug,
            'content' => $dto->content,
            'type' => $dto->type,
            'is_active' => $dto->isActive,
            'expired_at' => $dto->expiredAt,
        ];

        if ($dto->attachment) {
            if ($announcement->attachment && Storage::disk('public')->exists($announcement->attachment)) {
                Storage::disk('public')->delete($announcement->attachment);
            }
            $data['attachment'] = $dto->attachment->store('announcements', 'public');
        }

        return $this->repository->update($id, $data);
    }

    public function deleteAnnouncement(string $id): bool
    {
        $announcement = $this->repository->findById($id);
        if ($announcement && $announcement->attachment) {
            if (Storage::disk('public')->exists($announcement->attachment)) {
                Storage::disk('public')->delete($announcement->attachment);
            }
        }
        return $this->repository->delete($id);
    }
}
