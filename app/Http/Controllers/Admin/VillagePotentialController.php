<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillagePotential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class VillagePotentialController extends Controller
{
    private array $categories = [
        'Wisata', 'Pertanian', 'Peternakan', 'Perikanan', 'Kerajinan', 'Budaya', 'Investasi', 'SDA', 'UMKM'
    ];

    public function index(Request $request): View
    {
        $query = VillagePotential::latest();

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $potentials = $query->paginate(15)->withQueryString();
        $categories = $this->categories;

        return view('admin.potentials.index', compact('potentials', 'categories'));
    }

    public function create(): View
    {
        $categories = $this->categories;
        return view('admin.potentials.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => 'required|string',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'required|image|max:5120',
            'location' => 'nullable|string|max:1000',
            'contact_name' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'status' => 'required|in:published,draft',
            'gallery_files.*' => 'nullable|image|max:5120'
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('potentials', 'public');
        }

        $galleryImages = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                if ($file->isValid()) {
                    $galleryImages[] = $file->store('potentials/gallery', 'public');
                }
            }
        }
        $validated['gallery_images'] = !empty($galleryImages) ? $galleryImages : null;

        VillagePotential::create($validated);

        return redirect()->route('admin.potentials.index')->with('success', 'Potensi Desa berhasil ditambahkan.');
    }

    public function edit(VillagePotential $potential): View
    {
        $categories = $this->categories;
        return view('admin.potentials.edit', compact('potential', 'categories'));
    }

    public function update(Request $request, VillagePotential $potential): RedirectResponse
    {
        $validated = $request->validate([
            'category' => 'required|string',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|max:5120',
            'location' => 'nullable|string|max:1000',
            'contact_name' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'status' => 'required|in:published,draft',
            'gallery_files.*' => 'nullable|image|max:5120',
            'remove_galleries' => 'nullable|array' // Array of paths to delete
        ]);

        if ($request->name !== $potential->name) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
        }

        if ($request->hasFile('cover_image')) {
            if ($potential->cover_image) {
                Storage::disk('public')->delete($potential->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('potentials', 'public');
        }

        $existingGalleries = $potential->gallery_images ?? [];

        // Handle deletions
        if ($request->has('remove_galleries')) {
            foreach ($request->remove_galleries as $pathToRemove) {
                Storage::disk('public')->delete($pathToRemove);
                $existingGalleries = array_diff($existingGalleries, [$pathToRemove]);
            }
            // Re-index array
            $existingGalleries = array_values($existingGalleries);
        }

        // Handle new additions
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                if ($file->isValid()) {
                    $existingGalleries[] = $file->store('potentials/gallery', 'public');
                }
            }
        }

        $validated['gallery_images'] = !empty($existingGalleries) ? $existingGalleries : null;

        $potential->update($validated);

        return redirect()->route('admin.potentials.index')->with('success', 'Potensi Desa berhasil diperbarui.');
    }

    public function destroy(VillagePotential $potential): RedirectResponse
    {
        $potential->delete();
        return redirect()->route('admin.potentials.index')->with('success', 'Potensi Desa berhasil dihapus.');
    }
}
