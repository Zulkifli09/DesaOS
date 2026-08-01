<x-pelayanan-layout title="Detail Surat {{ $surat->nomor_surat ?? 'Draft' }}">
    <div class="p-6 max-w-4xl mx-auto">

        {{-- Breadcrumb + Header --}}
        <div class="mb-6">
            <a href="{{ route('pelayanan.surat.riwayat') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-700 mb-4">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Riwayat Surat
            </a>

            <div class="flex flex-col sm:flex-row sm:items-start gap-4 justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-3xl shrink-0">
                        {{ $surat->jenis_surat?->icon() }}
                    </div>
                    <div>
                        <h1 class="font-outfit font-bold text-xl text-slate-900">{{ $surat->jenis_surat?->label() }}</h1>
                        <p class="text-sm text-slate-500 mt-0.5">{{ $surat->nomor_surat ?? 'Belum bernomor' }}</p>
                    </div>
                </div>

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
                <span class="self-start sm:self-center px-4 py-2 rounded-xl text-sm font-semibold border {{ $statusColors[$surat->status->value] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                    {{ $surat->status->label() }}
                </span>
            </div>
        </div>

        {{-- Actions (draft) --}}
        @if($surat->isEditable())
        <div class="flex flex-wrap gap-3 mb-6">
            <a href="{{ route('pelayanan.surat.edit', $surat->id) }}" 
               class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-50 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Draft
            </a>
            <form action="{{ route('pelayanan.surat.submit', $surat->id) }}" method="POST" onsubmit="return confirm('Ajukan permohonan ini sekarang?')">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg transition-all shadow-blue-500/30">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Ajukan Sekarang
                </button>
            </form>
            <form action="{{ route('pelayanan.surat.destroy', $surat->id) }}" method="POST" onsubmit="return confirm('Hapus draft ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 bg-white border border-red-200 text-red-600 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus Draft
                </button>
            </form>
        </div>
        @endif

        @if($surat->status->value === 'selesai')
        <div class="flex flex-wrap gap-3 mb-6">
            <a href="{{ route('pelayanan.surat.pdf', $surat->id) }}" target="_blank"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg transition-all shadow-green-500/30">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Download Surat PDF
            </a>
        </div>
        @endif

        {{-- Rejection notice --}}
        @if($surat->status->value === 'ditolak' && $surat->catatan_penolakan)
        <div class="bg-red-50 border border-red-200 rounded-2xl p-5 mb-6">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <h3 class="font-semibold text-red-800">Alasan Penolakan</h3>
                    <p class="text-sm text-red-700 mt-1">{{ $surat->catatan_penolakan }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($surat->status->value === 'revisi' && $surat->catatan_operator)
        <div class="bg-purple-50 border border-purple-200 rounded-2xl p-5 mb-6">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-purple-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <div>
                    <h3 class="font-semibold text-purple-800">Catatan Revisi</h3>
                    <p class="text-sm text-purple-700 mt-1">{{ $surat->catatan_operator }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Left: Detail + Documents --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Data Permohonan --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="font-outfit font-bold text-slate-900">Data Permohonan</h2>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @php
                        $fields = [
                            'Nama Pemohon'    => $surat->nama_pemohon,
                            'NIK'             => $surat->nik_pemohon,
                            'No. HP/WA'       => $surat->no_hp_pemohon ?? '-',
                            'Alamat'          => $surat->alamat_pemohon,
                            'Keperluan'       => $surat->keperluan,
                            'Tgl Pengajuan'   => $surat->tanggal_pengajuan?->format('d F Y') ?? '-',
                            'Est. Selesai'    => $surat->estimasi_selesai?->format('d F Y') ?? '-',
                        ];
                        if ($surat->tanggal_selesai) $fields['Tgl Selesai'] = $surat->tanggal_selesai->format('d F Y');
                        if ($surat->catatan_pemohon) $fields['Catatan Pemohon'] = $surat->catatan_pemohon;
                        @endphp
                        @foreach($fields as $label => $value)
                        <div class="px-6 py-3 flex gap-4">
                            <span class="text-sm text-slate-500 w-36 shrink-0">{{ $label }}</span>
                            <span class="text-sm text-slate-900 font-medium flex-1">{{ $value }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Uploaded Documents --}}
                @if($surat->dokumens->count())
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="font-outfit font-bold text-slate-900">Dokumen Pendukung ({{ $surat->dokumens->count() }})</h2>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($surat->dokumens as $dok)
                        <div class="flex items-center gap-4 px-6 py-3">
                            <svg class="w-8 h-8 text-blue-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-900 truncate">{{ $dok->nama_dokumen }}</p>
                                <p class="text-xs text-slate-400">{{ $dok->file_name }} • {{ number_format($dok->file_size / 1024, 0) }} KB</p>
                            </div>
                            <a href="{{ Storage::url($dok->file_path) }}" target="_blank" class="text-xs text-blue-600 hover:underline font-medium shrink-0">Lihat</a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Approval Stages --}}
                @if($surat->approvalWorkflow)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="font-outfit font-bold text-slate-900">Riwayat Persetujuan</h2>
                    </div>
                    <div class="p-6 space-y-3">
                        @foreach($surat->approvalWorkflow->stages as $stage)
                        <div class="flex items-start gap-3">
                            @php
                            $actionColors = ['approved' => 'bg-green-100 text-green-700', 'rejected' => 'bg-red-100 text-red-700', 'revision' => 'bg-yellow-100 text-yellow-700'];
                            @endphp
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center shrink-0 text-sm font-bold text-slate-500">
                                {{ $loop->iteration }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-sm font-semibold text-slate-900">{{ $stage->stage?->label() }}</span>
                                    <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $actionColors[$stage->action] ?? 'bg-gray-100 text-gray-600' }}">{{ ucfirst($stage->action) }}</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-0.5">oleh {{ $stage->user?->name ?? 'Sistem' }} • {{ $stage->actioned_at?->format('d M Y H:i') }}</p>
                                @if($stage->catatan)
                                <p class="text-xs text-slate-600 bg-slate-50 rounded-lg px-3 py-2 mt-2">{{ $stage->catatan }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
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
                            @forelse($surat->timelines as $timeline)
                            <li class="ml-6">
                                <span class="absolute flex items-center justify-center w-7 h-7 rounded-full -left-3.5 ring-4 ring-white
                                    {{ $timeline->status?->value === 'selesai' ? 'bg-green-500' : ($timeline->status?->value === 'ditolak' ? 'bg-red-500' : 'bg-blue-500') }}">
                                    <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                                <div>
                                    <h3 class="text-sm font-semibold text-slate-900">{{ $timeline->judul }}</h3>
                                    @if($timeline->deskripsi)
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $timeline->deskripsi }}</p>
                                    @endif
                                    <time class="text-xs text-slate-400 mt-1 flex items-center gap-1">
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

                {{-- QR Code --}}
                @if($surat->status->value === 'selesai' && $surat->qr_code)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="font-outfit font-bold text-slate-900">Kode Verifikasi</h2>
                    </div>
                    <div class="p-6 text-center">
                        <img src="{{ Storage::url($surat->qr_code) }}" alt="QR Code Verifikasi" class="w-40 h-40 mx-auto rounded-xl">
                        <p class="text-xs text-slate-500 mt-3">Scan QR untuk memverifikasi keaslian dokumen</p>
                        <a href="{{ $surat->verification_url }}" target="_blank" class="mt-2 inline-block text-xs text-blue-600 hover:underline">Cek keaslian surat →</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-pelayanan-layout>
