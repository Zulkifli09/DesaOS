<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Media Galeri') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ mediaType: '{{ old('type', $gallery->type) }}' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Album -->
                        <div>
                            <label for="album_id" class="block text-sm font-medium text-gray-700">Pilih Album</label>
                            <select name="album_id" id="album_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">(Tanpa Album)</option>
                                @foreach($albums as $album)
                                    <option value="{{ $album->id }}" {{ old('album_id', $gallery->album_id) == $album->id ? 'selected' : '' }}>
                                        {{ $album->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('album_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul Media <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $gallery->title) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Singkat (Opsional)</label>
                            <textarea id="description" name="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('description', $gallery->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Media Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Tipe Media <span class="text-red-500">*</span></label>
                            <select name="type" id="type" x-model="mediaType" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-100" readonly>
                                <option value="image" {{ $gallery->type == 'image' ? 'selected' : '' }}>Gambar (Foto)</option>
                                <option value="video" {{ $gallery->type == 'video' ? 'selected' : '' }}>Video (YouTube/Link)</option>
                                <option value="drone" {{ $gallery->type == 'drone' ? 'selected' : '' }}>Drone / Panorama Udara (YouTube/Link)</option>
                            </select>
                            <p class="text-xs text-red-500 mt-1">Perhatian: Anda tidak dapat mengubah tipe media setelah dibuat.</p>
                        </div>

                        <!-- Media File (For Image) -->
                        <div x-show="mediaType === 'image'" x-transition>
                            <label class="block text-sm font-medium text-gray-700">Gambar (Biarkan kosong jika tidak ingin mengganti)</label>
                            @if($gallery->type === 'image' && $gallery->media_path)
                                <div class="mb-2 mt-1">
                                    <img src="{{ Storage::url($gallery->media_path) }}" alt="Preview" class="h-32 rounded object-cover shadow">
                                </div>
                            @endif
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="media_file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Pilih File Baru</span>
                                            <input id="media_file" name="media_file" type="file" class="sr-only" accept="image/*">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG maksimal 10MB</p>
                                </div>
                            </div>
                            @error('media_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Media URL (For Video/Drone) -->
                        <div x-show="mediaType !== 'image'" x-transition style="display: none;">
                            <label for="media_url" class="block text-sm font-medium text-gray-700">Link Video / Embed URL <span class="text-red-500">*</span></label>
                            <input type="url" name="media_url" id="media_url" value="{{ old('media_url', $gallery->type !== 'image' ? $gallery->media_path : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('media_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Options -->
                        <div class="flex items-center gap-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="is_downloadable" name="is_downloadable" type="checkbox" value="1" {{ old('is_downloadable', $gallery->is_downloadable) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_downloadable" class="font-medium text-gray-700">Izinkan Publik Mengunduh (Download)</label>
                                </div>
                            </div>
                            
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 sr-only">Status</label>
                                <select name="status" id="status" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50">
                                    <option value="published" {{ old('status', $gallery->status) == 'published' ? 'selected' : '' }}>Langsung Publish</option>
                                    <option value="draft" {{ old('status', $gallery->status) == 'draft' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 pt-4 border-t">
                            <a href="{{ route('admin.galleries.index') }}" class="bg-gray-200 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Batal
                            </a>
                            <button type="submit" class="bg-indigo-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Media
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
