<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Dokumen Publik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.documents.update', $document->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul Dokumen <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $document->title) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Kategori / Jenis <span class="text-red-500">*</span></label>
                            <select name="category" id="category" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="Peraturan Desa" {{ old('category', $document->category) == 'Peraturan Desa' ? 'selected' : '' }}>Peraturan Desa</option>
                                <option value="Laporan Keuangan" {{ old('category', $document->category) == 'Laporan Keuangan' ? 'selected' : '' }}>Laporan Keuangan (APBDes)</option>
                                <option value="Formulir Pelayanan" {{ old('category', $document->category) == 'Formulir Pelayanan' ? 'selected' : '' }}>Formulir Pelayanan</option>
                                <option value="Dokumen Publik" {{ old('category', $document->category) == 'Dokumen Publik' ? 'selected' : '' }}>Dokumen Publik Umum</option>
                                <option value="Lainnya" {{ old('category', $document->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                            <textarea id="description" name="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('description', $document->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700">Ganti File Dokumen</label>
                            <p class="text-sm text-gray-600 mb-2">File saat ini: <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat File</a></p>
                            
                            <input type="file" name="file" id="file" accept=".pdf,.doc,.docx,.xls,.xlsx" class="mt-2 block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100
                                "/>
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti file. Format: PDF, DOC, DOCX, XLS, XLSX. Maks: 10MB.</p>
                            @error('file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex justify-end gap-2 pt-4 border-t">
                            <a href="{{ route('admin.documents.index') }}" class="bg-gray-200 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Batal
                            </a>
                            <button type="submit" class="bg-indigo-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Dokumen
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
