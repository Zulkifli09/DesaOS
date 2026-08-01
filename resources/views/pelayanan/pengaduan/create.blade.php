<x-pelayanan-layout title="Buat Pengaduan">
    <div class="p-6 max-w-3xl mx-auto">
        
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('pelayanan.pengaduan.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 mb-4">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center text-3xl shrink-0">
                    📢
                </div>
                <div>
                    <h1 class="font-outfit font-bold text-2xl text-slate-900">Buat Laporan Pengaduan</h1>
                    <p class="text-slate-500 text-sm mt-0.5">Sampaikan laporan Anda dengan detail yang jelas dan akurat.</p>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('pelayanan.pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Privacy Option --}}
            <div class="bg-indigo-50 border border-indigo-200 rounded-2xl p-5 mb-6 flex items-start gap-4">
                <div class="pt-0.5">
                    <input type="checkbox" name="is_anonim" id="is_anonim" value="1" class="w-5 h-5 text-indigo-600 border-indigo-300 rounded focus:ring-indigo-500 cursor-pointer">
                </div>
                <div>
                    <label for="is_anonim" class="font-semibold text-indigo-900 cursor-pointer text-sm block mb-1">Laporkan Secara Anonim</label>
                    <p class="text-xs text-indigo-700">Identitas Anda akan dirahasiakan dan tidak akan ditampilkan pada publik atau petugas yang tidak berwenang.</p>
                </div>
            </div>

            {{-- Form Card: Detail Laporan --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                    <h2 class="font-outfit font-bold text-slate-900">Detail Laporan</h2>
                </div>
                <div class="p-6 space-y-5">
                    
                    {{-- Judul --}}
                    <div>
                        <label for="judul" class="block text-sm font-semibold text-slate-700 mb-1.5">Judul Laporan <span class="text-red-500">*</span></label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"
                               placeholder="Contoh: Jalan berlubang di RT 01...">
                        @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kategori & Prioritas --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                            <select id="kategori" name="kategori" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none">
                                <option value="" disabled selected>Pilih Kategori...</option>
                                @foreach($kategoris as $kat)
                                <option value="{{ $kat->value }}" {{ old('kategori') === $kat->value ? 'selected' : '' }}>{{ $kat->label() }}</option>
                                @endforeach
                            </select>
                            @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="prioritas" class="block text-sm font-semibold text-slate-700 mb-1.5">Prioritas <span class="text-red-500">*</span></label>
                            <select id="prioritas" name="prioritas" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none">
                                @foreach($prioritas as $p)
                                <option value="{{ $p->value }}" {{ old('prioritas', 'rendah') === $p->value ? 'selected' : '' }}>{{ $p->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-1.5">Isi Laporan <span class="text-red-500">*</span></label>
                        <textarea id="deskripsi" name="deskripsi" rows="5" required minlength="20"
                                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"
                                  placeholder="Ceritakan detail kronologi atau keluhan Anda..."></textarea>
                        @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Lokasi --}}
                    <div>
                        <label for="lokasi_kejadian" class="block text-sm font-semibold text-slate-700 mb-1.5">Lokasi Kejadian (Opsional)</label>
                        <input type="text" id="lokasi_kejadian" name="lokasi_kejadian" value="{{ old('lokasi_kejadian') }}"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"
                               placeholder="Cth: Depan Balai Desa / RT 02 RW 01">
                    </div>
                </div>
            </div>

            {{-- Lampiran --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                    <h2 class="font-outfit font-bold text-slate-900">Lampiran Bukti (Opsional)</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Sertakan foto/dokumen pendukung. Maks 10MB.</p>
                </div>
                <div class="p-6">
                    <input type="file" name="dokumens[]" multiple accept=".jpg,.jpeg,.png,.pdf"
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all">
                </div>
            </div>

            {{-- Submit --}}
            <div>
                <button type="submit" 
                        class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-xl transition-all shadow-md shadow-indigo-500/20 text-sm">
                    Kirim Laporan Pengaduan
                </button>
            </div>
        </form>
    </div>
</x-pelayanan-layout>
