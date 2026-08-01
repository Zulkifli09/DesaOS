<x-pelayanan-layout title="Riwayat Pengaduan">
    <div class="p-6 max-w-5xl mx-auto">
        
        {{-- Header --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="font-outfit font-bold text-2xl text-slate-900">Riwayat Pengaduan</h1>
                <p class="text-slate-500 mt-1 text-sm">Pantau status laporan dan aspirasi yang telah Anda sampaikan.</p>
            </div>
            <a href="{{ route('pelayanan.pengaduan.create') }}" 
               class="inline-flex items-center justify-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                Buat Pengaduan Baru
            </a>
        </div>

        {{-- Filters --}}
        <div class="bg-white p-2 rounded-2xl border border-slate-200 shadow-sm flex overflow-x-auto hide-scrollbar mb-6">
            @php
            $filters = [
                '' => 'Semua Laporan',
                'menunggu' => 'Menunggu',
                'diproses' => 'Diproses',
                'selesai' => 'Selesai',
                'ditolak' => 'Ditolak',
            ];
            $currentFilter = request('status', '');
            @endphp
            @foreach($filters as $val => $label)
            <a href="{{ request()->fullUrlWithQuery(['status' => $val]) }}" 
               class="whitespace-nowrap px-5 py-2.5 rounded-xl text-sm font-medium transition-colors
                      {{ $currentFilter === $val ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>

        {{-- List --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            @if($pengaduans->count())
                <div class="divide-y divide-slate-100">
                    @foreach($pengaduans as $item)
                    @php
                        $statusColors = [
                            'menunggu' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                            'diproses' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'selesai'  => 'bg-green-100 text-green-700 border-green-200',
                            'ditolak'  => 'bg-red-100 text-red-700 border-red-200',
                        ];
                    @endphp
                    <a href="{{ route('pelayanan.pengaduan.show', $item->id) }}" class="block p-5 hover:bg-slate-50 transition-colors">
                        <div class="flex flex-col sm:flex-row gap-4 justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="inline-flex px-2 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600">
                                        {{ $item->kategori->label() }}
                                    </span>
                                    @if($item->is_anonim)
                                    <span class="inline-flex items-center gap-1 text-[10px] font-medium text-slate-500">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                        Anonim
                                    </span>
                                    @endif
                                </div>
                                <h3 class="font-bold text-slate-900 text-base mb-1 truncate">{{ $item->judul }}</h3>
                                <p class="text-sm text-slate-500 line-clamp-1">{{ Str::limit($item->deskripsi, 100) }}</p>
                                <p class="text-xs text-slate-400 mt-2 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Dilaporkan pada {{ $item->created_at->format('d M Y H:i') }}
                                </p>
                            </div>
                            <div class="shrink-0 flex sm:flex-col items-center sm:items-end justify-between">
                                <span class="inline-flex px-3 py-1 rounded-lg text-xs font-semibold border {{ $statusColors[$item->status->value] ?? 'bg-gray-100' }}">
                                    {{ $item->status->label() }}
                                </span>
                                <span class="text-indigo-600 text-sm font-medium flex items-center gap-1 group">
                                    Detail
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                <div class="p-4 border-t border-slate-100">
                    {{ $pengaduans->links('pagination::tailwind') }}
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-slate-900 mb-1">Belum ada laporan</h3>
                    <p class="text-sm text-slate-500 mb-6">Anda belum pernah membuat laporan pengaduan{{ $currentFilter ? ' dengan status ini' : '' }}.</p>
                    @if($currentFilter)
                    <a href="{{ route('pelayanan.pengaduan.riwayat') }}" class="text-indigo-600 text-sm font-medium hover:underline">Lihat semua laporan</a>
                    @endif
                </div>
            @endif
        </div>

    </div>
</x-pelayanan-layout>
