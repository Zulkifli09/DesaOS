<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function __construct(
        protected MediaService $mediaService
    ) {
    }

    public function index()
    {
        $medias = Media::latest()->paginate(24);
        return view('admin.media.index', compact('medias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // Max 10MB
        ]);

        $this->mediaService->upload($request->file('file'), 'uploads');

        return redirect()->route('admin.media.index')->with('success', 'File berhasil diunggah dan dioptimasi.');
    }

    public function destroy(Media $media)
    {
        $this->mediaService->delete($media);
        return redirect()->route('admin.media.index')->with('success', 'File berhasil dihapus.');
    }
}
