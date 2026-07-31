<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Gallery::with('album')->published();

        if ($request->has('type') && in_array($request->type, ['image', 'video', 'drone'])) {
            $query->where('type', $request->type);
        }

        if ($request->has('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        // Lazy loading is natively supported by Laravel pagination which yields smaller chunks
        $galleries = $query->latest()->paginate(12)->withQueryString();
        
        $albums = GalleryAlbum::withCount('galleries')->orderBy('name')->get();

        return view('frontend.galeri.index', compact('galleries', 'albums'));
    }

    public function album(string $slug): View
    {
        $album = GalleryAlbum::where('slug', $slug)->firstOrFail();
        $galleries = $album->galleries()->published()->latest()->paginate(12);
        
        return view('frontend.galeri.album', compact('album', 'galleries'));
    }
}
