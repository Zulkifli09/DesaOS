<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\VillagePotential;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $latestNews = Article::with('category', 'user')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        $emergencyAnnouncements = Announcement::active()
            ->where('type', 'darurat')
            ->latest()
            ->take(2)
            ->get();

        $galleries = Gallery::published()
            ->latest()
            ->take(6)
            ->get();

        $potentials = VillagePotential::published()
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.home', compact('latestNews', 'emergencyAnnouncements', 'galleries', 'potentials'));
    }
}
