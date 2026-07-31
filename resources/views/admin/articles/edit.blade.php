<x-admin-layout>
    <x-admin.breadcrumb title="Edit Berita" :links="['Publikasi' => null, 'Berita' => route('admin.articles.index'), 'Edit' => null]" />

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800 p-6">
        <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Judul Berita</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" required class="mt-1 block w-full rounded-lg border border-slate-300 bg-white py-2 px-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white sm:text-sm">
                        @error('title') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Konten Berita</label>
                        <textarea name="content" id="content" rows="12" required class="mt-1 block w-full rounded-lg border border-slate-300 bg-white py-2 px-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white sm:text-sm">{{ old('content', $article->content) }}</textarea>
                        @error('content') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-lg border border-slate-200 dark:border-slate-700 p-4">
                        <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-4">Pengaturan Publikasi</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white py-2 px-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white sm:text-sm">
                                    <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Kategori</label>
                                <select name="category_id" id="category_id" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white py-2 px-3 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white sm:text-sm">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Gambar Utama</label>
                                @if($article->image)
                                    <div class="mb-2">
                                        <img src="{{ Storage::url($article->image) }}" alt="Current Image" class="h-32 w-full object-cover rounded-md">
                                    </div>
                                @endif
                                <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 dark:text-slate-400 dark:file:bg-emerald-900/30 dark:file:text-emerald-400">
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Kosongkan jika tidak ingin mengganti gambar.</p>
                                @error('image') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                Perbarui Berita
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>
