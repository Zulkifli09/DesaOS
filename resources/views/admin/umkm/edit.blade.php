<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data UMKM: ') }} {{ $umkm->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.umkm.update', $umkm->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Kategori -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Kategori UMKM <span class="text-red-500">*</span></label>
                            <select name="category" id="category" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $umkm->category) == $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                            <!-- Name -->
                            <div class="sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Toko / Usaha <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $umkm->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- WhatsApp -->
                            <div>
                                <label for="whatsapp" class="block text-sm font-medium text-gray-700">WhatsApp / Telepon <span class="text-red-500">*</span></label>
                                <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $umkm->whatsapp) }}" required placeholder="Contoh: 628123456789" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('whatsapp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Instagram -->
                            <div>
                                <label for="instagram" class="block text-sm font-medium text-gray-700">Link/Username Instagram</label>
                                <input type="text" name="instagram" id="instagram" value="{{ old('instagram', $umkm->instagram) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('instagram') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Operational Hours -->
                            <div>
                                <label for="operational_hours" class="block text-sm font-medium text-gray-700">Jam Operasional</label>
                                <input type="text" name="operational_hours" id="operational_hours" value="{{ old('operational_hours', $umkm->operational_hours) }}" placeholder="Contoh: Sen-Sab, 08:00 - 17:00" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('operational_hours') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="location" id="location" value="{{ old('location', $umkm->location) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Maps URL -->
                            <div class="sm:col-span-2">
                                <label for="maps_url" class="block text-sm font-medium text-gray-700">Link Google Maps (Opsional)</label>
                                <input type="url" name="maps_url" id="maps_url" value="{{ old('maps_url', $umkm->maps_url) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('maps_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi & Produk Utama <span class="text-red-500">*</span></label>
                            <textarea id="description" name="description" rows="5" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('description', $umkm->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Images Section -->
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Media UMKM</h3>
                            
                            <!-- Logo / Cover -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700">Logo / Foto Utama Lapak</label>
                                @if($umkm->logo)
                                    <div class="mb-3 mt-2">
                                        <p class="text-sm text-gray-500 mb-1">Logo Saat Ini:</p>
                                        <img src="{{ Storage::url($umkm->logo) }}" alt="Logo" class="h-32 rounded object-cover shadow-sm">
                                    </div>
                                @endif
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md bg-white">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="logo" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Pilih Logo Baru</span>
                                                <input id="logo" name="logo" type="file" class="sr-only" accept="image/*">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">Abaikan jika tidak ingin mengganti.</p>
                                    </div>
                                </div>
                                @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <hr class="my-6">

                            <!-- Multiple Gallery Images -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Etalase Produk Tambahan</label>
                                
                                @if($umkm->gallery_images && count($umkm->gallery_images) > 0)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-2">Galeri Saat Ini (Centang untuk menghapus):</p>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            @foreach($umkm->gallery_images as $index => $imgPath)
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
                                    <p class="text-sm text-gray-500 mb-1">Tambah Foto Produk Baru (Bisa pilih banyak):</p>
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
                        <div class="flex flex-col sm:flex-row gap-6 items-start sm:items-center">
                            
                            <div class="flex items-center">
                                <input id="is_featured" name="is_featured" type="checkbox" value="1" {{ old('is_featured', $umkm->is_featured) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <label for="is_featured" class="ml-2 block text-sm font-medium text-gray-700">Jadikan UMKM Unggulan (Featured)</label>
                            </div>
                            
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 sr-only">Status Publikasi</label>
                                <select name="status" id="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-50">
                                    <option value="published" {{ old('status', $umkm->status) == 'published' ? 'selected' : '' }}>Langsung Publish</option>
                                    <option value="draft" {{ old('status', $umkm->status) == 'draft' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 pt-4 border-t">
                            <a href="{{ route('admin.umkm.index') }}" class="bg-gray-200 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Batal
                            </a>
                            <button type="submit" class="bg-indigo-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Data
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
