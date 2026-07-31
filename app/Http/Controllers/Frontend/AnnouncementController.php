<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of active announcements.
     */
    public function index(Request $request): View
    {
        $query = Announcement::with('user')->active();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->has('type')) {
            $type = $request->input('type');
            $query->where('type', $type);
        }

        $announcements = $query->latest()->paginate(10)->withQueryString();

        return view('frontend.pengumuman.index', compact('announcements'));
    }

    /**
     * Display the specified announcement.
     */
    public function show(string $slug): View
    {
        $announcement = Announcement::with('user')
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $relatedAnnouncements = Announcement::active()
            ->where('type', $announcement->type)
            ->where('id', '!=', $announcement->id)
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.pengumuman.show', compact('announcement', 'relatedAnnouncements'));
    }
}
