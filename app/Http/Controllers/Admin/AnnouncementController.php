<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTOs\AnnouncementDTO;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\AnnouncementRepositoryInterface;
use App\Services\AnnouncementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function __construct(
        private readonly AnnouncementRepositoryInterface $repository,
        private readonly AnnouncementService $service
    ) {
    }

    public function index(): View
    {
        $announcements = $this->repository->getAllPaginated();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create(): View
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:umum,darurat,kegiatan',
            'is_active' => 'boolean',
            'expired_at' => 'nullable|date',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $dto = AnnouncementDTO::fromArray($validated + ['attachment' => $request->file('attachment')]);
        
        $this->service->createAnnouncement($dto, (string) auth()->id());

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(string $id): View
    {
        $announcement = $this->repository->findById($id);
        abort_if(!$announcement, 404);

        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:umum,darurat,kegiatan',
            'is_active' => 'boolean',
            'expired_at' => 'nullable|date',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $dto = AnnouncementDTO::fromArray($validated + ['attachment' => $request->file('attachment')]);
        
        $this->service->updateAnnouncement($id, $dto);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->service->deleteAnnouncement($id);
        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
