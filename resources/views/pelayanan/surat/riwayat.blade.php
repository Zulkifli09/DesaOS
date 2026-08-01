<x-pelayanan-layout title="Riwayat Surat Online">
    <div class="p-6">
        
        {{-- Header --}}
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="font-outfit font-bold text-2xl text-slate-900">Riwayat Surat</h1>
                <p class="text-slate-500 mt-1 text-sm">Pantau status permohonan surat yang telah Anda ajukan.</p>
            </div>
            <a href="{{ route('pelayanan.surat.index') }}" 
               class="inline-flex items-center justify-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Buat Surat Baru
            </a>
        </div>

        {{-- Filter Tabs --}}
        <div class="bg-white p-2 rounded-2xl border border-slate-200 shadow-sm flex overflow-x-auto hide-scrollbar mb-6">
            @php
            $filters = [
                '' => 'Semua Surat',
                'draft' => 'Draft',
                'diproses' => 'Diproses',
                'menunggu_persetujuan' => 'Menunggu Persetujuan',
                'selesai' => 'Selesai',
                'ditolak' => 'Ditolak',
            ];
            $currentFilter = request('status', '');
            @endphp
            @foreach($filters as $val => $label)
            <a href="{{ request()->fullUrlWithQuery(['status' => $val]) }}" 
               class="whitespace-nowrap px-5 py-2.5 rounded-xl text-sm font-medium transition-colors
                      {{ $currentFilter === $val ? 'bg-slate-100 text-slate-900' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>

        {{-- List --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            @if($surats->count())
                <div class="divide-y divide-slate-100">
                    @foreach($surats as $surat)
                    @php
                        $statusColors = [
                            'draft'               => 'bg-gray-100 text-gray-700 border-gray-200',
                            'diajukan'            => 'bg-blue-100 text-blue-700 border-blue-200',
                            'diverifikasi'        => 'bg-cyan-100 text-cyan-700 border-cyan-200',
                            'diproses'            => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                            'menunggu_persetujuan'=> 'bg-orange-100 text-orange-700 border-orange-200',
                            'selesai'             => 'bg-green-100 text-green-700 border-green-200',
                            'ditolak'             => 'bg-red-100 text-red-700 border-red-200',
                            'revisi'              => 'bg-purple-100 text-purple-700 border-purple-200',
                        ];
                    @endphp
                    <div class="p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-slate-50 transition-colors">
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-2xl shrink-0">
                                {{ $surat->jenis_surat?->icon() }}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-base mb-0.5">{{ $surat->jenis_surat?->label() }}</h3>
                                <p class="text-sm text-slate-500 flex items-center gap-2">
                                    <span class="font-medium text-slate-700">{{ $surat->nomor_surat ?? 'Draft' }}</span>
                                    <span>•</span>
                                    <span>{{ $surat->created_at->format('d M Y') }}</span>
                                </p>
                                <div class="mt-2 hidden sm:block">
                                    <p class="text-xs text-slate-400">Pemohon: {{ $surat->nama_pemohon }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between md:flex-col md:items-end gap-3 shrink-0">
                            <span class="inline-flex px-3 py-1 rounded-lg text-xs font-semibold border {{ $statusColors[$surat->status->value] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                {{ $surat->status->label() }}
                            </span>
                            <a href="{{ route('pelayanan.surat.show', $surat->id) }}" 
                               class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1 group">
                                Cek Detail
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="p-4 border-t border-slate-100">
                    {{ $surats->links('pagination::tailwind') }}
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-slate-900 mb-1">Tidak ada riwayat surat</h3>
                    <p class="text-sm text-slate-500 mb-6">Anda belum mengajukan surat apapun dengan status ini.</p>
                    @if($currentFilter)
                    <a href="{{ route('pelayanan.surat.riwayat') }}" class="text-blue-600 text-sm font-medium hover:underline">Lihat semua surat</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-pelayanan-layout>
