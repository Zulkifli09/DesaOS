<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pelayanan;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function __construct(
        protected NotificationService $notificationService,
    ) {}

    /**
     * Show notification center.
     */
    public function index(Request $request)
    {
        $notifikasis = Notifikasi::forUser(auth()->id())
            ->when($request->filter === 'unread', fn ($q) => $q->unread())
            ->latest()
            ->paginate(20);

        $unreadCount = $this->notificationService->getUnreadCount(auth()->id());

        return view('pelayanan.notifikasi.index', compact('notifikasis', 'unreadCount'));
    }

    /**
     * Mark a single notification as read.
     */
    public function read(Notifikasi $notifikasi)
    {
        abort_unless($notifikasi->user_id === auth()->id(), 403);

        $this->notificationService->markAsRead($notifikasi);

        if ($notifikasi->url) {
            return redirect($notifikasi->url);
        }

        return back();
    }

    /**
     * Mark all notifications as read.
     */
    public function readAll()
    {
        $this->notificationService->markAllAsRead(auth()->id());

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * API: Get unread count (for badge).
     */
    public function unreadCount()
    {
        return response()->json([
            'count' => $this->notificationService->getUnreadCount(auth()->id()),
        ]);
    }
}
