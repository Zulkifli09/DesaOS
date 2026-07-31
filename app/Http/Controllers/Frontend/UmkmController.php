<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UmkmController extends Controller
{
    private array $categories = [
        'Kuliner', 'Fashion', 'Kriya / Kerajinan', 'Jasa', 'Agrobisnis', 'Lainnya'
    ];

    public function index(Request $request): View
    {
        $query = Umkm::published();

        if ($request->has('category') && in_array($request->category, $this->categories)) {
            $query->where('category', $request->category);
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $umkms = $query->latest()->paginate(12)->withQueryString();
        $categories = $this->categories;
        
        // Only fetch featured if no search or category filter is active (to show on main index)
        $featuredUmkms = collect();
        if (!$request->has('search') && !$request->has('category')) {
            $featuredUmkms = Umkm::published()->featured()->latest()->take(5)->get();
        }

        return view('frontend.umkm.index', compact('umkms', 'categories', 'featuredUmkms'));
    }

    public function show(string $slug): View
    {
        $umkm = Umkm::published()->where('slug', $slug)->firstOrFail();
        
        $relatedUmkms = Umkm::published()
            ->where('category', $umkm->category)
            ->where('id', '!=', $umkm->id)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.umkm.show', compact('umkm', 'relatedUmkms'));
    }
}
