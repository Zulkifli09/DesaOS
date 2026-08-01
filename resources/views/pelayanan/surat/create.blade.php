<x-pelayanan-layout title="Formulir {{ $jenisSurat->label() }}">
    <div class="p-6 max-w-3xl mx-auto">
        
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('pelayanan.surat.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 mb-4">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-3xl shrink-0">
                    {{ $jenisSurat->icon() }}
                </div>
                <div>
                    <h1 class="font-outfit font-bold text-2xl text-slate-900">{{ $jenisSurat->label() }}</h1>
                    <p class="text-slate-500 text-sm mt-0.5">{{ $jenisSurat->description() }}</p>
                </div>
            </div>
        </div>

        {{-- Persyaratan Card --}}
        @if($template?->persyaratan)
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-6">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3 class="font-semibold text-amber-900">Dokumen Persyaratan</h3>
            </div>
            <ul class="space-y-1.5">
                @foreach($template->persyaratan as $req)
                <li class="flex items-start gap-2 text-sm text-amber-800">
                    <svg class="w-4 h-4 text-amber-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $req }}
                </li>
                @endforeach
            </ul>
            <p class="text-xs text-amber-700 mt-3 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Estimasi waktu proses: {{ $template->estimasi_hari ?? $jenisSurat->estimasiHari() }} hari kerja
            </p>
        </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('pelayanan.surat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="jenis_surat" value="{{ $jenisSurat->value }}">
            @if($template)
            <input type="hidden" name="surat_template_id" value="{{ $template->id }}">
            @endif

            {{-- Form Card: Data Pemohon --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                    <h2 class="font-outfit font-bold text-slate-900">Data Pemohon</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Isi dengan data sesuai KTP yang berlaku</p>
                </div>
                <div class="p-6 space-y-5">
                    
                    {{-- Nama Pemohon --}}
                    <div>
                        <label for="nama_pemohon" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_pemohon" name="nama_pemohon" value="{{ old('nama_pemohon', auth()->user()->name) }}" required
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all @error('nama_pemohon') border-red-400 @enderror">
                        @error('nama_pemohon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- NIK --}}
                    <div>
                        <label for="nik_pemohon" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            NIK (16 Digit) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nik_pemohon" name="nik_pemohon" value="{{ old('nik_pemohon') }}" required maxlength="16" pattern="[0-9]{16}"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all font-mono tracking-widest @error('nik_pemohon') border-red-400 @enderror"
                               placeholder="3201XXXXXXXXXXXXXX">
                        @error('nik_pemohon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- No HP --}}
                    <div>
                        <label for="no_hp_pemohon" class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor WhatsApp / HP</label>
                        <input type="tel" id="no_hp_pemohon" name="no_hp_pemohon" value="{{ old('no_hp_pemohon') }}"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all"
                               placeholder="08XXXXXXXXXX">
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label for="alamat_pemohon" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea id="alamat_pemohon" name="alamat_pemohon" rows="3" required
                                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all @error('alamat_pemohon') border-red-400 @enderror"
                                  placeholder="RT/RW, Dusun, Desa...">{{ old('alamat_pemohon') }}</textarea>
                        @error('alamat_pemohon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Form Card: Keperluan --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                    <h2 class="font-outfit font-bold text-slate-900">Keperluan & Keterangan</h2>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <label for="keperluan" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Keperluan / Tujuan Surat <span class="text-red-500">*</span>
                        </label>
                        <textarea id="keperluan" name="keperluan" rows="4" required minlength="20"
                                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all @error('keperluan') border-red-400 @enderror"
                                  placeholder="Jelaskan keperluan / tujuan penggunaan surat ini dengan jelas...">{{ old('keperluan') }}</textarea>
                        @error('keperluan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="catatan_pemohon" class="block text-sm font-semibold text-slate-700 mb-1.5">Catatan Tambahan (Opsional)</label>
                        <textarea id="catatan_pemohon" name="catatan_pemohon" rows="2"
                                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all"
                                  placeholder="Catatan khusus atau informasi tambahan untuk petugas...">{{ old('catatan_pemohon') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Upload Dokumen --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
                    <h2 class="font-outfit font-bold text-slate-900">Upload Dokumen Persyaratan</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Format: PDF, JPG, PNG. Maksimal 5 MB per file. Maks. 10 file.</p>
                </div>
                <div class="p-6">
                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-8 text-center hover:border-blue-400 transition-colors cursor-pointer" id="upload-area">
                        <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-sm font-medium text-slate-700">Klik atau drag & drop file di sini</p>
                        <p class="text-xs text-slate-400 mt-1">PDF, JPG, PNG — maks. 5 MB per file</p>
                        <input type="file" name="dokumens[]" multiple accept=".pdf,.jpg,.jpeg,.png" 
                               class="hidden" id="file-input"
                               onchange="handleFileSelect(this)">
                        <label for="file-input" class="mt-4 inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-medium cursor-pointer hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Pilih File
                        </label>
                    </div>
                    <div id="file-list" class="mt-3 space-y-2 hidden"></div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" name="action" value="draft"
                        class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold py-3 px-6 rounded-xl transition-colors text-sm">
                    💾 Simpan sebagai Draft
                </button>
                <button type="submit" name="action" value="submit"
                        class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-xl transition-all shadow-lg shadow-blue-500/30 hover:shadow-xl text-sm">
                    🚀 Ajukan Sekarang
                </button>
            </div>
        </form>
    </div>

    <script>
        function handleFileSelect(input) {
            const files = Array.from(input.files);
            const list = document.getElementById('file-list');
            list.innerHTML = '';
            
            if (files.length > 0) {
                list.classList.remove('hidden');
                files.forEach((file, i) => {
                    const size = (file.size / 1024 / 1024).toFixed(2);
                    const div = document.createElement('div');
                    div.className = 'flex items-center justify-between bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5';
                    div.innerHTML = `
                        <div class="flex items-center gap-2 min-w-0">
                            <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="text-sm text-slate-700 truncate">${file.name}</span>
                        </div>
                        <span class="text-xs text-slate-400 shrink-0 ml-2">${size} MB</span>
                    `;
                    list.appendChild(div);
                });
            } else {
                list.classList.add('hidden');
            }
        }

        // Drag & drop
        const uploadArea = document.getElementById('upload-area');
        uploadArea.addEventListener('dragover', e => { e.preventDefault(); uploadArea.classList.add('border-blue-500', 'bg-blue-50'); });
        uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('border-blue-500', 'bg-blue-50'));
        uploadArea.addEventListener('drop', e => {
            e.preventDefault();
            uploadArea.classList.remove('border-blue-500', 'bg-blue-50');
            const fileInput = document.getElementById('file-input');
            fileInput.files = e.dataTransfer.files;
            handleFileSelect(fileInput);
        });

        // NIK input validation - only numbers
        document.getElementById('nik_pemohon').addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0, 16);
        });
    </script>
</x-pelayanan-layout>
