<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display a listing of articles.
     */
    public function index(Request $request): View
    {
        $query = Article::with('category', 'user')
            ->where('status', 'published');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->has('kategori')) {
            $categorySlug = $request->input('kategori');
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $featuredNews = Article::with('category', 'user')
            ->where('status', 'published')
            ->where('is_featured', true)
            ->latest('published_at')
            ->take(2)
            ->get();

        $popularNews = Article::with('category')
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        $articles = $query->latest('published_at')->paginate(9)->withQueryString();
        
        $categories = Category::withCount(['articles' => function ($q) {
            $q->where('status', 'published');
        }])->get();

        return view('frontend.berita.index', compact('articles', 'featuredNews', 'popularNews', 'categories'));
    }

    /**
     * Display the specified article.
     */
    public function show(string $slug): View
    {
        $article = Article::with('category', 'user')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increment view count
        $article->increment('views');

        $relatedNews = Article::with('category')
            ->where('status', 'published')
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        $popularNews = Article::with('category')
            ->where('status', 'published')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();
            
        $categories = Category::withCount(['articles' => function ($q) {
            $q->where('status', 'published');
        }])->get();

        return view('frontend.berita.show', compact('article', 'relatedNews', 'popularNews', 'categories'));
    }
}
