<x-pelayanan-layout title="Edit Surat {{ $surat->nomor_surat ?? 'Draft' }}">
    <div class="p-6 max-w-3xl mx-auto">
        
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('pelayanan.surat.show', $surat->id) }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 mb-4">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Batal Edit
            </a>
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-3xl shrink-0">
                    {{ $surat->jenis_surat?->icon() }}
                </div>
                <div>
                    <h1 class="font-outfit font-bold text-2xl text-slate-900">Edit {{ $surat->jenis_surat?->label() }}</h1>
                    <p class="text-slate-500 text-sm mt-0.5">Perbarui data permohonan surat Anda.</p>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('pelayanan.surat.update', $surat->id) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')
            <input type="hidden" name="jenis_surat" value="{{ $surat->jenis_surat->value }}">

            {{-- Form Card: Data Pemohon --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                    <h2 class="font-outfit font-bold text-slate-900">Data Pemohon</h2>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <label for="nama_pemohon" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="nama_pemohon" name="nama_pemohon" value="{{ old('nama_pemohon', $surat->nama_pemohon) }}" required
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                        @error('nama_pemohon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="nik_pemohon" class="block text-sm font-semibold text-slate-700 mb-1.5">NIK (16 Digit) <span class="text-red-500">*</span></label>
                        <input type="text" id="nik_pemohon" name="nik_pemohon" value="{{ old('nik_pemohon', $surat->nik_pemohon) }}" required maxlength="16" pattern="[0-9]{16}"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all font-mono">
                        @error('nik_pemohon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="no_hp_pemohon" class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor HP</label>
                        <input type="tel" id="no_hp_pemohon" name="no_hp_pemohon" value="{{ old('no_hp_pemohon', $surat->no_hp_pemohon) }}"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    </div>

                    <div>
                        <label for="alamat_pemohon" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea id="alamat_pemohon" name="alamat_pemohon" rows="3" required
                                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">{{ old('alamat_pemohon', $surat->alamat_pemohon) }}</textarea>
                        @error('alamat_pemohon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Form Card: Keperluan --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                    <h2 class="font-outfit font-bold text-slate-900">Keperluan</h2>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <label for="keperluan" class="block text-sm font-semibold text-slate-700 mb-1.5">Keperluan Surat <span class="text-red-500">*</span></label>
                        <textarea id="keperluan" name="keperluan" rows="4" required minlength="20"
                                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">{{ old('keperluan', $surat->keperluan) }}</textarea>
                        @error('keperluan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="catatan_pemohon" class="block text-sm font-semibold text-slate-700 mb-1.5">Catatan (Opsional)</label>
                        <textarea id="catatan_pemohon" name="catatan_pemohon" rows="2"
                                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">{{ old('catatan_pemohon', $surat->catatan_pemohon) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition-all shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-pelayanan-layout>
