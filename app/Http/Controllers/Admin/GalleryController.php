<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Gallery::with('album')->latest();

        if ($request->has('album_id') && $request->album_id != '') {
            $query->where('album_id', $request->album_id);
        }

        $galleries = $query->paginate(15)->withQueryString();
        $albums = GalleryAlbum::orderBy('name')->get();

        return view('admin.galleries.index', compact('galleries', 'albums'));
    }

    public function create(): View
    {
        $albums = GalleryAlbum::orderBy('name')->get();
        return view('admin.galleries.create', compact('albums'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'album_id' => 'nullable|exists:gallery_albums,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video,drone',
            'is_downloadable' => 'nullable|boolean',
            'status' => 'required|in:published,draft',
        ]);

        if ($request->type === 'image') {
            $request->validate(['media_file' => 'required|image|max:10240']); // max 10MB for image
            $validated['media_path'] = $request->file('media_file')->store('galleries', 'public');
        } else {
            // video or drone could be a URL or embed link
            $request->validate(['media_url' => 'required|string']);
            $validated['media_path'] = $request->input('media_url');
        }

        $validated['is_downloadable'] = $request->has('is_downloadable') ? true : false;

        Gallery::create($validated);

        return redirect()->route('admin.galleries.index')->with('success', 'Media galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery): View
    {
        $albums = GalleryAlbum::orderBy('name')->get();
        return view('admin.galleries.edit', compact('gallery', 'albums'));
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'album_id' => 'nullable|exists:gallery_albums,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:image,video,drone',
            'is_downloadable' => 'nullable|boolean',
            'status' => 'required|in:published,draft',
        ]);

        if ($request->type === 'image') {
            if ($request->hasFile('media_file')) {
                $request->validate(['media_file' => 'nullable|image|max:10240']);
                // delete old file if it was an image
                if ($gallery->type === 'image' && $gallery->media_path) {
                    Storage::disk('public')->delete($gallery->media_path);
                }
                $validated['media_path'] = $request->file('media_file')->store('galleries', 'public');
            } else {
                $validated['media_path'] = $gallery->media_path;
            }
        } else {
            $request->validate(['media_url' => 'required|string']);
            $validated['media_path'] = $request->input('media_url');
        }

        $validated['is_downloadable'] = $request->has('is_downloadable') ? true : false;

        $gallery->update($validated);

        return redirect()->route('admin.galleries.index')->with('success', 'Media galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Media galeri berhasil dihapus.');
    }
}
