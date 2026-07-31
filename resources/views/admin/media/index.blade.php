<x-admin-layout>
    <x-admin.breadcrumb title="Galeri Media" :links="['Sistem' => null, 'Media' => route('admin.media.index')]" />

    <div class="mb-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
        <h2 class="mb-4 text-lg font-semibold text-slate-900 dark:text-white">Unggah Media Baru</h2>
        <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            @csrf
            <div class="flex-1 w-full">
                <input type="file" name="file" id="file" required class="block w-full text-sm text-slate-500 file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-emerald-700 hover:file:bg-emerald-100 dark:text-slate-400 dark:file:bg-emerald-900/30 dark:file:text-emerald-400 focus:outline-none">
            </div>
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                Unggah & Optimasi
            </button>
        </form>
        @error('file') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
        @forelse($medias as $media)
            <div class="group relative aspect-square overflow-hidden rounded-xl border border-slate-200 bg-slate-100 dark:border-slate-700 dark:bg-slate-800">
                @if(str_starts_with($media->mime_type, 'image/'))
                    <img src="{{ Storage::url($media->path) }}" alt="{{ $media->file_name }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                @else
                    <div class="flex h-full w-full flex-col items-center justify-center p-4 text-slate-400">
                        <svg class="mb-2 h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                        <span class="text-center text-xs truncate w-full">{{ $media->file_name }}</span>
                    </div>
                @endif
                
                <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/60 opacity-0 backdrop-blur-sm transition-opacity duration-300 group-hover:opacity-100">
                    <p class="mb-2 px-2 text-center text-xs font-medium text-white truncate w-full">{{ $media->file_name }}</p>
                    <p class="mb-4 text-xs text-slate-300">{{ round($media->size / 1024, 2) }} KB</p>
                    
                    <form method="POST" action="{{ route('admin.media.destroy', $media) }}" onsubmit="return confirm('Hapus permanen file ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-red-500">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-xl border border-dashed border-slate-300 py-12 text-center dark:border-slate-600">
                <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada file media yang diunggah.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $medias->links() }}
    </div>
</x-admin-layout>
