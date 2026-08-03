<x-admin-layout>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.layanan.pengaduan.index') }}" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white line-clamp-1" title="{{ $pengaduan->judul }}">{{ $pengaduan->judul }}</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    {{ $pengaduan->kategori->label() }} • 
                    Oleh: {{ $pengaduan->is_anonim ? 'Anonim' : $pengaduan->user->name }} • 
                    {{ $pengaduan->created_at->format('d M Y H:i') }}
                </p>
            </div>
        </div>
        
        <div class="flex items-center gap-2">
            @php
                $prioColors = [
                    'rendah' => 'bg-slate-100 text-slate-700',
                    'menengah' => 'bg-yellow-100 text-yellow-700',
                    'tinggi' => 'bg-red-100 text-red-700',
                    'darurat' => 'bg-rose-600 text-white animate-pulse',
                ];
                $statusColors = [
                    'menunggu' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                    'diproses' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                    'selesai'  => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                    'ditolak'  => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                ];
            @endphp
            <span class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider {{ $prioColors[$pengaduan->prioritas->value] ?? '' }}">
                {{ $pengaduan->prioritas->label() }}
            </span>
            <span class="px-4 py-1.5 rounded-lg text-sm font-semibold border {{ $statusColors[$pengaduan->status->value] ?? 'bg-slate-100' }}">
                Status: {{ $pengaduan->status->label() }}
            </span>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-400 px-4 py-3 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-400 px-4 py-3 rounded-xl text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Detail Laporan -->
        <div class="xl:col-span-2 space-y-6">
            
            <!-- Isi Pengaduan -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
                    <h2 class="font-bold text-slate-900 dark:text-white">Deskripsi Laporan</h2>
                </div>
                <div class="p-6">
                    <div class="prose prose-sm dark:prose-invert max-w-none text-slate-700 dark:text-slate-300">
                        {!! nl2br(e($pengaduan->deskripsi)) !!}
                    </div>

                    @if($pengaduan->lokasi_kejadian)
                    <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-700 flex items-start gap-2 text-slate-600 dark:text-slate-400">
                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <div>
                            <span class="block text-xs font-semibold mb-0.5">Lokasi Kejadian:</span>
                            <span class="text-sm">{{ $pengaduan->lokasi_kejadian }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Bukti Lampiran -->
            @if($pengaduan->dokumens->count())
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
                    <h2 class="font-bold text-slate-900 dark:text-white">Lampiran Bukti ({{ $pengaduan->dokumens->count() }})</h2>
                </div>
                <div class="p-6 grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach($pengaduan->dokumens as $dok)
                    <a href="{{ Storage::url($dok->file_path) }}" target="_blank" class="group block border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden hover:border-blue-300 dark:hover:border-blue-500 transition-colors">
                        @if(Str::endsWith(strtolower($dok->file_path), ['.jpg','.jpeg','.png']))
                        <div class="aspect-video bg-slate-100 dark:bg-slate-900 relative">
                            <img src="{{ Storage::url($dok->file_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="Bukti">
                        </div>
                        @else
                        <div class="aspect-video bg-slate-50 dark:bg-slate-900 flex items-center justify-center">
                            <svg class="w-10 h-10 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        @endif
                        <div class="p-2 bg-slate-50 dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 text-center">
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 truncate">{{ $dok->file_name }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Diskusi / Komentar -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
                    <h2 class="font-bold text-slate-900 dark:text-white">Catatan & Interaksi Internal</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Hanya dapat dilihat oleh admin dan pelapor.</p>
                </div>
                
                <!-- List Komentar -->
                <div class="p-6 space-y-6">
                    @forelse($pengaduan->komentars as $komentar)
                    <div class="flex gap-4 {{ $komentar->user_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                        <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center shrink-0 font-bold text-xs">
                            {{ substr($komentar->user->name, 0, 1) }}
                        </div>
                        <div class="flex flex-col {{ $komentar->user_id === auth()->id() ? 'items-end' : 'items-start' }} max-w-[80%]">
                            <div class="flex items-center gap-2 mb-1 px-1">
                                <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">
                                    {{ $komentar->user_id === $pengaduan->user_id && $pengaduan->is_anonim ? 'Pelapor (Anonim)' : $komentar->user->name }}
                                </span>
                                <span class="text-[10px] text-slate-400">{{ $komentar->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="px-4 py-2.5 rounded-2xl text-sm {{ $komentar->user_id === auth()->id() ? 'bg-blue-600 text-white rounded-tr-none' : 'bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-200 rounded-tl-none' }}">
                                {!! nl2br(e($komentar->komentar)) !!}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-sm text-slate-500 py-4">Belum ada diskusi internal.</div>
                    @endforelse
                </div>

                <!-- Form Balas Komentar -->
                @if(in_array($pengaduan->status->value, ['menunggu', 'diproses']))
                <div class="p-4 border-t border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/30">
                    <form action="{{ route('admin.layanan.pengaduan.comment', $pengaduan->id) }}" method="POST" class="flex gap-3">
                        @csrf
                        <input type="text" name="komentar" required placeholder="Tulis balasan untuk pelapor..." class="flex-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2 text-sm focus:ring-blue-500">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-medium transition-colors shrink-0">Kirim</button>
                    </form>
                </div>
                @endif
            </div>

        </div>

        <!-- Kolom Kanan: Tindak Lanjut -->
        <div class="space-y-6">
            
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
                    <h2 class="font-bold text-slate-900 dark:text-white">Tindak Lanjut Laporan</h2>
                </div>
                <div class="p-6">
                    
                    @if($pengaduan->status->value === 'menunggu')
                        <div class="space-y-4 text-sm text-slate-600 dark:text-slate-400">
                            <p>Laporan baru masuk. Periksa kebenaran laporan ini. Jika valid, ubah status menjadi Diproses untuk mulai penanganan.</p>
                            
                            <form action="{{ route('admin.layanan.pengaduan.update-status', $pengaduan->id) }}" method="POST" class="flex flex-col gap-3">
                                @csrf @method('PUT')
                                <button type="submit" name="status" value="diproses" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-medium transition-colors">
                                    Tandai Sedang Diproses
                                </button>
                                <button type="submit" name="status" value="ditolak" onclick="return confirm('Tolak laporan ini karena tidak valid?')" class="w-full bg-slate-100 hover:bg-red-100 dark:bg-slate-700 dark:hover:bg-red-900/30 text-slate-700 dark:text-slate-300 hover:text-red-700 dark:hover:text-red-400 py-2.5 rounded-lg font-medium transition-colors">
                                    Tolak Laporan (Tidak Valid)
                                </button>
                            </form>
                        </div>
                    
                    @elseif($pengaduan->status->value === 'diproses')
                        <form action="{{ route('admin.layanan.pengaduan.update-status', $pengaduan->id) }}" method="POST" class="space-y-4">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="selesai">
                            
                            <div>
                                <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-2">Tanggapan Resmi (Publik) <span class="text-red-500">*</span></label>
                                <p class="text-[10px] text-slate-500 mb-2">Tanggapan ini akan ditampilkan kepada pelapor sebagai hasil penyelesaian akhir.</p>
                                <textarea name="tanggapan_resmi" rows="5" required class="w-full text-sm rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50" placeholder="Tuliskan tindakan yang telah dilakukan untuk menyelesaikan masalah ini..."></textarea>
                            </div>

                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 rounded-lg transition-colors text-sm">
                                Selesaikan Laporan
                            </button>
                        </form>
                    
                    @elseif($pengaduan->status->value === 'selesai' || $pengaduan->status->value === 'ditolak')
                        
                        @if($pengaduan->tanggapan_resmi)
                        <div class="mb-4">
                            <h3 class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-wider">Tanggapan Resmi (Selesai):</h3>
                            <div class="bg-green-50 dark:bg-green-900/20 text-green-800 dark:text-green-400 p-4 rounded-xl text-sm">
                                {!! nl2br(e($pengaduan->tanggapan_resmi)) !!}
                            </div>
                        </div>
                        @endif
                        
                        <div class="text-center p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl">
                            <p class="text-sm text-slate-500 font-medium">Laporan ini sudah {{ $pengaduan->status->label() }} dan ditutup.</p>
                        </div>

                    @endif

                </div>
            </div>

        </div>

    </div>
</x-admin-layout>
