<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class GalleryAlbumController extends Controller
{
    public function index(): View
    {
        $albums = GalleryAlbum::withCount('galleries')->latest()->paginate(10);
        return view('admin.gallery_albums.index', compact('albums'));
    }

    public function create(): View
    {
        return view('admin.gallery_albums.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:5120',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('albums', 'public');
        }

        GalleryAlbum::create($validated);

        return redirect()->route('admin.gallery_albums.index')->with('success', 'Album berhasil ditambahkan.');
    }

    public function edit(GalleryAlbum $galleryAlbum): View
    {
        return view('admin.gallery_albums.edit', compact('galleryAlbum'));
    }

    public function update(Request $request, GalleryAlbum $galleryAlbum): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:5120',
        ]);

        if ($request->name !== $galleryAlbum->name) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
        }

        if ($request->hasFile('cover_image')) {
            if ($galleryAlbum->cover_image) {
                Storage::disk('public')->delete($galleryAlbum->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('albums', 'public');
        }

        $galleryAlbum->update($validated);

        return redirect()->route('admin.gallery_albums.index')->with('success', 'Album berhasil diperbarui.');
    }

    public function destroy(GalleryAlbum $galleryAlbum): RedirectResponse
    {
        // Option to delete cover image? Soft delete keeps it.
        $galleryAlbum->delete();
        return redirect()->route('admin.gallery_albums.index')->with('success', 'Album berhasil dihapus.');
    }
}
