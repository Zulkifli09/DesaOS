<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Document::query();

        if ($request->filled('search')) {
            $query->where('title', 'ilike', '%' . $request->search . '%')
                  ->orWhere('description', 'ilike', '%' . $request->search . '%');
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(12);
        
        // Get all unique categories for filter
        $categories = Document::select('category')->distinct()->pluck('category');

        return view('frontend.dokumen.index', compact('documents', 'categories'));
    }

    public function download(Document $document)
    {
        if (!Storage::exists($document->file_path)) {
            abort(404, 'File not found');
        }

        // Increment download count
        $document->increment('downloads_count');

        return Storage::download($document->file_path, $document->title . '.' . pathinfo($document->file_path, PATHINFO_EXTENSION));
    }
}
