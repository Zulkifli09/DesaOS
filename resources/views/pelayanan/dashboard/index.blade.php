@php use App\Enums\JenisSurat; @endphp

<x-pelayanan-layout title="Dashboard Layanan">
    <div class="p-6 space-y-8">

        {{-- Hero / Welcome --}}
        <div class="bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-600 rounded-2xl p-6 md:p-8 text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-indigo-300 rounded-full blur-2xl transform -translate-x-1/3 translate-y-1/3"></div>
            </div>
            <div class="relative z-10">
                <p class="text-blue-100 text-sm font-medium">Selamat datang kembali,</p>
                <h1 class="font-outfit text-2xl md:text-3xl font-bold mt-1">{{ auth()->user()->name }} 👋</h1>
                <p class="text-blue-100 text-sm mt-2 max-w-lg">Akses seluruh layanan administrasi desa secara digital, cepat, mudah, dan aman.</p>
                <div class="mt-5 flex flex-wrap gap-3">
                    <a href="{{ route('pelayanan.surat.index') }}" class="inline-flex items-center gap-2 bg-white text-blue-700 font-semibold px-4 py-2.5 rounded-xl text-sm hover:bg-blue-50 transition-all shadow-lg">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Buat Surat Baru
                    </a>
                    <a href="{{ route('pelayanan.pengaduan.create') }}" class="inline-flex items-center gap-2 bg-white/20 text-white font-semibold px-4 py-2.5 rounded-xl text-sm hover:bg-white/30 transition-all border border-white/30">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                        Buat Pengaduan
                    </a>
                    <a href="{{ route('pelayanan.surat.riwayat') }}" class="inline-flex items-center gap-2 bg-white/10 text-white font-medium px-4 py-2.5 rounded-xl text-sm hover:bg-white/20 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Riwayat Saya
                    </a>
                </div>
            </div>
        </div>

        {{-- Announcements --}}
        @if($announcements->count())
        <div class="space-y-2">
            @foreach($announcements as $ann)
            <div class="flex items-start gap-3 px-5 py-4 rounded-xl border {{ $ann->tipeClass() }}">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="font-semibold text-sm">{{ $ann->judul }}</p>
                    <p class="text-sm mt-0.5 opacity-80">{{ $ann->isi }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
            $statItems = [
                ['label' => 'Total Surat', 'value' => $stats['surat_total'], 'bg' => 'from-blue-50 to-blue-100', 'text' => 'text-blue-800'],
                ['label' => 'Surat Diproses', 'value' => $stats['surat_proses'], 'bg' => 'from-yellow-50 to-yellow-100', 'text' => 'text-yellow-800'],
                ['label' => 'Surat Selesai', 'value' => $stats['surat_selesai'], 'bg' => 'from-green-50 to-green-100', 'text' => 'text-green-800'],
                ['label' => 'Total Pengaduan', 'value' => $stats['pengaduan_total'], 'bg' => 'from-purple-50 to-purple-100', 'text' => 'text-purple-800'],
                ['label' => 'Pengaduan Proses', 'value' => $stats['pengaduan_proses'], 'bg' => 'from-orange-50 to-orange-100', 'text' => 'text-orange-800'],
                ['label' => 'Pengaduan Selesai', 'value' => $stats['pengaduan_selesai'], 'bg' => 'from-emerald-50 to-emerald-100', 'text' => 'text-emerald-800'],
            ];
            @endphp
            @foreach($statItems as $stat)
            <div class="bg-gradient-to-br {{ $stat['bg'] }} rounded-2xl p-4 border border-white/50 shadow-sm">
                <p class="text-3xl font-outfit font-bold {{ $stat['text'] }}">{{ $stat['value'] }}</p>
                <p class="text-xs text-slate-500 mt-1 font-medium">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Active Surat in Progress --}}
        @if($active_surat->count())
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
                <h2 class="font-outfit font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                    Sedang Diproses
                </h2>
                <a href="{{ route('pelayanan.surat.riwayat') }}" class="text-sm text-blue-600 hover:underline font-medium">Lihat semua →</a>
            </div>
            <div class="divide-y divide-slate-100">
                @foreach($active_surat as $surat)
                @php
                    $statusColors = [
                        'draft'               => 'bg-gray-100 text-gray-700',
                        'diajukan'            => 'bg-blue-100 text-blue-700',
                        'diverifikasi'        => 'bg-cyan-100 text-cyan-700',
                        'diproses'            => 'bg-yellow-100 text-yellow-700',
                        'menunggu_persetujuan'=> 'bg-orange-100 text-orange-700',
                        'selesai'             => 'bg-green-100 text-green-700',
                        'ditolak'             => 'bg-red-100 text-red-700',
                        'revisi'              => 'bg-purple-100 text-purple-700',
                    ];
                    $statusClass = $statusColors[$surat->status->value] ?? 'bg-gray-100 text-gray-700';
                @endphp
                <a href="{{ route('pelayanan.surat.show', $surat->id) }}" class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-xl shrink-0">
                        {{ $surat->jenis_surat?->icon() }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-slate-900 text-sm truncate">{{ $surat->jenis_surat?->label() }}</p>
                        <p class="text-xs text-slate-400 truncate mt-0.5">{{ $surat->nomor_surat ?? 'Belum bernomor' }} • {{ $surat->nama_pemohon }}</p>
                    </div>
                    <div class="shrink-0">
                        {{-- Progress bar --}}
                        <div class="flex items-center gap-2">
                            <div class="w-16 bg-slate-200 rounded-full h-1.5 hidden sm:block">
                                <div class="bg-blue-500 h-1.5 rounded-full transition-all" style="width: {{ $surat->progressPercent() }}%"></div>
                            </div>
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusClass }}">
                                {{ $surat->status->label() }}
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Service Types Grid --}}
        <div>
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="font-outfit font-bold text-slate-900 text-lg">Pilih Jenis Layanan Surat</h2>
                    <p class="text-sm text-slate-500 mt-0.5">Klik layanan yang Anda butuhkan untuk mulai mengajukan</p>
                </div>
                <a href="{{ route('pelayanan.surat.index') }}" class="text-sm text-blue-600 hover:underline font-medium hidden sm:block">Lihat semua →</a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($surat_templates as $template)
                <a href="{{ route('pelayanan.surat.create', $template->jenis_surat->value) }}" 
                   class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-xl hover:border-blue-300 hover:-translate-y-1 transition-all group text-center cursor-pointer">
                    <div class="text-3xl mb-3 transition-transform group-hover:scale-110">{{ $template->jenis_surat->icon() }}</div>
                    <h3 class="font-semibold text-slate-800 text-sm group-hover:text-blue-700 transition-colors leading-snug">{{ $template->jenis_surat->label() }}</h3>
                    <p class="text-xs text-slate-400 mt-1.5 flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        ±{{ $template->estimasi_hari }} hari kerja
                    </p>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Recent + FAQ Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            {{-- Recent Surat --}}
            <div class="lg:col-span-3 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h2 class="font-outfit font-bold text-slate-900">Riwayat Terbaru</h2>
                    <a href="{{ route('pelayanan.surat.riwayat') }}" class="text-sm text-blue-600 hover:underline font-medium">Lihat semua →</a>
                </div>
                @if($recent_surat->count())
                <div class="divide-y divide-slate-100">
                    @foreach($recent_surat as $surat)
                    @php
                        $statusColors2 = ['draft' => 'bg-gray-100 text-gray-600', 'diajukan' => 'bg-blue-100 text-blue-700', 'diverifikasi' => 'bg-cyan-100 text-cyan-700', 'diproses' => 'bg-yellow-100 text-yellow-700', 'menunggu_persetujuan' => 'bg-orange-100 text-orange-700', 'selesai' => 'bg-green-100 text-green-700', 'ditolak' => 'bg-red-100 text-red-700', 'revisi' => 'bg-purple-100 text-purple-700'];
                    @endphp
                    <a href="{{ route('pelayanan.surat.show', $surat->id) }}" class="flex items-center gap-4 px-6 py-3 hover:bg-slate-50 transition-colors">
                        <div class="text-xl">{{ $surat->jenis_surat?->icon() }}</div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-800 truncate">{{ $surat->jenis_surat?->label() }}</p>
                            <p class="text-xs text-slate-400">{{ $surat->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium shrink-0 {{ $statusColors2[$surat->status->value] ?? 'bg-gray-100 text-gray-600' }}">
                            {{ $surat->status->label() }}
                        </span>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="px-6 py-16 text-center">
                    <div class="text-5xl mb-4">📄</div>
                    <p class="text-slate-500 font-medium">Belum ada riwayat surat</p>
                    <p class="text-slate-400 text-sm mt-1">Mulai ajukan surat pertama Anda sekarang.</p>
                    <a href="{{ route('pelayanan.surat.index') }}" class="mt-4 inline-block text-sm bg-blue-600 text-white px-4 py-2 rounded-xl font-medium hover:bg-blue-700 transition-colors">Buat Surat →</a>
                </div>
                @endif
            </div>

            {{-- FAQ --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="font-outfit font-bold text-slate-900">Pertanyaan Umum</h2>
                </div>
                <div class="p-4 space-y-2">
                    @forelse($faqs->take(6) as $faq)
                    <details class="group border border-slate-100 rounded-xl">
                        <summary class="flex items-center justify-between px-4 py-3 cursor-pointer text-sm font-medium text-slate-800 hover:bg-slate-50 rounded-xl list-none">
                            <span class="pr-2">{{ $faq->pertanyaan }}</span>
                            <svg class="w-4 h-4 text-slate-400 shrink-0 group-open:rotate-180 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </summary>
                        <div class="px-4 pb-3 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-2">{{ $faq->jawaban }}</div>
                    </details>
                    @empty
                    <div class="text-center py-8">
                        <p class="text-slate-400 text-sm">Belum ada FAQ tersedia.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</x-pelayanan-layout>
