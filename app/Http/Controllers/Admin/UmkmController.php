<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UmkmController extends Controller
{
    private array $categories = [
        'Kuliner', 'Fashion', 'Kriya / Kerajinan', 'Jasa', 'Agrobisnis', 'Lainnya'
    ];

    public function index(Request $request): View
    {
        $query = Umkm::latest();

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $umkms = $query->paginate(15)->withQueryString();
        $categories = $this->categories;

        return view('admin.umkm.index', compact('umkms', 'categories'));
    }

    public function create(): View
    {
        $categories = $this->categories;
        return view('admin.umkm.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'logo' => 'required|image|max:5120',
            'location' => 'required|string|max:1000',
            'maps_url' => 'nullable|url',
            'whatsapp' => 'required|string|max:50',
            'instagram' => 'nullable|string|max:255',
            'operational_hours' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:published,draft',
            'gallery_files.*' => 'nullable|image|max:5120'
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
        $validated['is_featured'] = $request->has('is_featured') ? true : false;

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('umkm', 'public');
        }

        $galleryImages = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                if ($file->isValid()) {
                    $galleryImages[] = $file->store('umkm/gallery', 'public');
                }
            }
        }
        $validated['gallery_images'] = !empty($galleryImages) ? $galleryImages : null;

        Umkm::create($validated);

        return redirect()->route('admin.umkm.index')->with('success', 'Data UMKM berhasil ditambahkan.');
    }

    public function edit(Umkm $umkm): View
    {
        $categories = $this->categories;
        return view('admin.umkm.edit', compact('umkm', 'categories'));
    }

    public function update(Request $request, Umkm $umkm): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'logo' => 'nullable|image|max:5120',
            'location' => 'required|string|max:1000',
            'maps_url' => 'nullable|url',
            'whatsapp' => 'required|string|max:50',
            'instagram' => 'nullable|string|max:255',
            'operational_hours' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:published,draft',
            'gallery_files.*' => 'nullable|image|max:5120',
            'remove_galleries' => 'nullable|array'
        ]);

        if ($request->name !== $umkm->name) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
        }

        $validated['is_featured'] = $request->has('is_featured') ? true : false;

        if ($request->hasFile('logo')) {
            if ($umkm->logo) {
                Storage::disk('public')->delete($umkm->logo);
            }
            $validated['logo'] = $request->file('logo')->store('umkm', 'public');
        }

        $existingGalleries = $umkm->gallery_images ?? [];

        // Handle deletions
        if ($request->has('remove_galleries')) {
            foreach ($request->remove_galleries as $pathToRemove) {
                Storage::disk('public')->delete($pathToRemove);
                $existingGalleries = array_diff($existingGalleries, [$pathToRemove]);
            }
            $existingGalleries = array_values($existingGalleries);
        }

        // Handle new additions
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                if ($file->isValid()) {
                    $existingGalleries[] = $file->store('umkm/gallery', 'public');
                }
            }
        }

        $validated['gallery_images'] = !empty($existingGalleries) ? $existingGalleries : null;

        $umkm->update($validated);

        return redirect()->route('admin.umkm.index')->with('success', 'Data UMKM berhasil diperbarui.');
    }

    public function destroy(Umkm $umkm): RedirectResponse
    {
        $umkm->delete();
        return redirect()->route('admin.umkm.index')->with('success', 'Data UMKM berhasil dihapus.');
    }
}
