<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Potensi Desa: ') }} {{ $potential->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.potentials.update', $potential->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Kategori -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Kategori Potensi <span class="text-red-500">*</span></label>
                            <select name="category" id="category" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $potential->category) == $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            <!-- Name -->
                            <div class="sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Potensi / Produk / Wisata <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $potential->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Contact Name -->
                            <div>
                                <label for="contact_name" class="block text-sm font-medium text-gray-700">Nama Kontak / Penanggung Jawab</label>
                                <input type="text" name="contact_name" id="contact_name" value="{{ old('contact_name', $potential->contact_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('contact_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Contact Phone -->
                            <div>
                                <label for="contact_phone" class="block text-sm font-medium text-gray-700">Nomor Telepon / WhatsApp</label>
                                <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $potential->contact_phone) }}" placeholder="Contoh: 628123456789" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('contact_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <!-- Location -->
                            <div class="sm:col-span-2">
                                <label for="location" class="block text-sm font-medium text-gray-700">Lokasi / Alamat</label>
                                <input type="text" name="location" id="location" value="{{ old('location', $potential->location) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Detail <span class="text-red-500">*</span></label>
                            <textarea id="description" name="description" rows="5" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('description', $potential->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Images Section -->
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Media & Galeri</h3>
                            
                            <!-- Cover Image -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700">Foto Utama (Thumbnail)</label>
                                @if($potential->cover_image)
                                    <div class="mb-3 mt-2">
                                        <p class="text-sm text-gray-500 mb-1">Foto Utama Saat Ini:</p>
                                        <img src="{{ Storage::url($potential->cover_image) }}" alt="Cover" class="h-32 rounded object-cover">
                                    </div>
                                @endif
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md bg-white">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="cover_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Pilih Foto Utama Baru</span>
                                                <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/*">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">Abaikan jika tidak ingin mengganti. PNG, JPG maks 5MB.</p>
                                    </div>
                                </div>
                                @error('cover_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <hr class="my-6">

                            <!-- Multiple Gallery Images -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Galeri Tambahan</label>
                                
                                @if($potential->gallery_images && count($potential->gallery_images) > 0)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-2">Galeri Saat Ini (Centang untuk menghapus):</p>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            @foreach($potential->gallery_images as $index => $imgPath)
                                                <div class="relative group border rounded p-1 bg-white">
                                                    <img src="{{ Storage::url($imgPath) }}" class="h-24 w-full object-cover rounded">
                                                    <div class="absolute top-2 right-2 bg-white rounded-sm px-1 shadow">
                                                        <label class="inline-flex items-center">
                                                            <input type="checkbox" name="remove_galleries[]" value="{{ $imgPath }}" class="form-checkbox text-red-600 h-4 w-4">
                                                            <span class="ml-1 text-xs text-red-600 font-bold">Hapus</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-4">
                                    <p class="text-sm text-gray-500 mb-1">Tambah Foto Galeri Baru (Bisa pilih banyak):</p>
                                    <input type="file" name="gallery_files[]" id="gallery_files" multiple accept="image/*" class="block w-full text-sm text-slate-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-indigo-50 file:text-indigo-700
                                        hover:file:bg-indigo-100
                                        "/>
                                    @error('gallery_files.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Options -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status Publikasi</label>
                            <select name="status" id="status" required class="mt-1 block w-full sm:w-64 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50">
                                <option value="published" {{ old('status', $potential->status) == 'published' ? 'selected' : '' }}>Langsung Publish</option>
                                <option value="draft" {{ old('status', $potential->status) == 'draft' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                            </select>
                        </div>

                        <div class="flex justify-end gap-2 pt-4 border-t">
                            <a href="{{ route('admin.potentials.index') }}" class="bg-gray-200 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Batal
                            </a>
                            <button type="submit" class="bg-indigo-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Potensi
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
