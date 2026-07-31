<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\VillagePotential;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VillagePotentialController extends Controller
{
    private array $categories = [
        'Wisata', 'Pertanian', 'Peternakan', 'Perikanan', 'Kerajinan', 'Budaya', 'Investasi', 'SDA', 'UMKM'
    ];

    public function index(Request $request): View
    {
        $query = VillagePotential::published();

        if ($request->has('category') && in_array($request->category, $this->categories)) {
            $query->where('category', $request->category);
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $potentials = $query->latest()->paginate(12)->withQueryString();
        $categories = $this->categories;

        return view('frontend.potensi.index', compact('potentials', 'categories'));
    }

    public function show(string $slug): View
    {
        $potential = VillagePotential::published()->where('slug', $slug)->firstOrFail();
        
        // get related based on category
        $relatedPotentials = VillagePotential::published()
            ->where('category', $potential->category)
            ->where('id', '!=', $potential->id)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.potensi.show', compact('potential', 'relatedPotentials'));
    }
}
