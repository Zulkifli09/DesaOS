<x-pelayanan-layout title="Detail Laporan Pengaduan">
    <div class="p-6 max-w-4xl mx-auto">
        
        {{-- Breadcrumb + Header --}}
        <div class="mb-6">
            <a href="{{ route('pelayanan.pengaduan.riwayat') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 mb-4">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Riwayat Pengaduan
            </a>

            <div class="flex flex-col sm:flex-row sm:items-start gap-4 justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-100">
                            {{ $pengaduan->kategori->label() }}
                        </span>
                        @php
                            $prioColors = [
                                'rendah' => 'bg-slate-100 text-slate-600',
                                'menengah' => 'bg-yellow-100 text-yellow-700',
                                'tinggi' => 'bg-red-100 text-red-700',
                                'darurat' => 'bg-rose-600 text-white animate-pulse'
                            ];
                        @endphp
                        <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $prioColors[$pengaduan->prioritas->value] ?? 'bg-slate-100 text-slate-600' }}">
                            Prioritas: {{ $pengaduan->prioritas->label() }}
                        </span>
                    </div>
                    <h1 class="font-outfit font-bold text-2xl text-slate-900 leading-tight">{{ $pengaduan->judul }}</h1>
                    <p class="text-sm text-slate-500 mt-2 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Oleh: {{ $pengaduan->is_anonim ? 'Anonim' : $pengaduan->user->name }}
                        <span class="text-slate-300">•</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $pengaduan->created_at->translatedFormat('l, d F Y H:i') }}
                    </p>
                </div>

                @php
                    $statusColors = [
                        'menunggu' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                        'diproses' => 'bg-blue-100 text-blue-700 border-blue-200',
                        'selesai'  => 'bg-green-100 text-green-700 border-green-200',
                        'ditolak'  => 'bg-red-100 text-red-700 border-red-200',
                    ];
                @endphp
                <span class="self-start sm:self-center px-4 py-2 rounded-xl text-sm font-semibold border {{ $statusColors[$pengaduan->status->value] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                    {{ $pengaduan->status->label() }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Left: Content --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Detail --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h2 class="font-outfit font-bold text-slate-900 mb-4">Isi Laporan</h2>
                    <div class="prose prose-slate prose-sm max-w-none text-slate-700">
                        {!! nl2br(e($pengaduan->deskripsi)) !!}
                    </div>

                    @if($pengaduans->lokasi_kejadian)
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-start gap-2">
                        <svg class="w-5 h-5 text-slate-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <div>
                            <p class="text-sm font-medium text-slate-900">Lokasi Kejadian</p>
                            <p class="text-sm text-slate-500">{{ $pengaduan->lokasi_kejadian }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Attachment --}}
                @if($pengaduan->dokumens->count())
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="font-outfit font-bold text-slate-900">Lampiran ({{ $pengaduan->dokumens->count() }})</h2>
                    </div>
                    <div class="p-6 grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($pengaduan->dokumens as $dok)
                        <a href="{{ Storage::url($dok->file_path) }}" target="_blank" class="group block border border-slate-200 rounded-xl overflow-hidden hover:border-indigo-300 transition-colors">
                            @if(Str::endsWith(strtolower($dok->file_path), ['.jpg','.jpeg','.png']))
                            <div class="aspect-square bg-slate-100 relative">
                                <img src="{{ Storage::url($dok->file_path) }}" alt="Lampiran" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                            @else
                            <div class="aspect-square bg-slate-50 flex items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </div>
                            @endif
                            <div class="p-2 bg-slate-50 border-t border-slate-200">
                                <p class="text-[10px] text-center text-slate-500 truncate">{{ $dok->file_name }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Tanggapan Resmi --}}
                @if($pengaduan->tanggapan_resmi)
                <div class="bg-indigo-50 border border-indigo-200 rounded-2xl p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 text-indigo-500">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    </div>
                    <div class="relative z-10">
                        <h2 class="font-outfit font-bold text-indigo-900 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Tanggapan Resmi Pemerintah Desa
                        </h2>
                        <div class="prose prose-sm max-w-none text-indigo-800">
                            {!! nl2br(e($pengaduan->tanggapan_resmi)) !!}
                        </div>
                        <p class="text-xs text-indigo-600 mt-4 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Ditanggapi oleh: {{ $pengaduan->penanggap?->name ?? 'Admin' }} pada {{ $pengaduan->ditanggapi_pada?->format('d M Y H:i') }}
                        </p>
                    </div>
                </div>
                @endif
            </div>

            {{-- Right: Timeline --}}
            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="font-outfit font-bold text-slate-900">Tracking Status</h2>
                    </div>
                    <div class="p-6">
                        <ol class="relative border-l border-slate-200 space-y-6">
                            @forelse($pengaduan->timelines as $timeline)
                            <li class="ml-6">
                                <span class="absolute flex items-center justify-center w-7 h-7 rounded-full -left-3.5 ring-4 ring-white
                                    {{ $timeline->status?->value === 'selesai' ? 'bg-green-500' : ($timeline->status?->value === 'ditolak' ? 'bg-red-500' : 'bg-indigo-500') }}">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                                <div>
                                    <h3 class="text-sm font-semibold text-slate-900">{{ $timeline->judul }}</h3>
                                    @if($timeline->deskripsi)
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $timeline->deskripsi }}</p>
                                    @endif
                                    <time class="text-[10px] text-slate-400 mt-1.5 flex items-center gap-1 font-medium">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $timeline->created_at->format('d M Y H:i') }}
                                    </time>
                                </div>
                            </li>
                            @empty
                            <p class="text-sm text-slate-400 ml-6">Belum ada aktivitas</p>
                            @endforelse
                        </ol>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-pelayanan-layout>
