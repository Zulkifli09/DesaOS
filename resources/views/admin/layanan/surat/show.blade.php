<x-admin-layout>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.layanan.surat.index') }}" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Proses Surat: {{ $surat->nama_pemohon }}</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $surat->jenis_surat->label() }} • {{ $surat->nomor_surat ?? 'Draft/Belum bernomor' }}</p>
            </div>
        </div>
        
        @php
            $statusColors = [
                'diajukan'            => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400',
                'diverifikasi'        => 'bg-cyan-100 text-cyan-700 border-cyan-200 dark:bg-cyan-900/30 dark:text-cyan-400',
                'diproses'            => 'bg-yellow-100 text-yellow-700 border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400',
                'menunggu_persetujuan'=> 'bg-orange-100 text-orange-700 border-orange-200 dark:bg-orange-900/30 dark:text-orange-400',
                'selesai'             => 'bg-green-100 text-green-700 border-green-200 dark:bg-green-900/30 dark:text-green-400',
                'ditolak'             => 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900/30 dark:text-red-400',
                'revisi'              => 'bg-purple-100 text-purple-700 border-purple-200 dark:bg-purple-900/30 dark:text-purple-400',
            ];
        @endphp
        <div class="px-4 py-2 rounded-xl border font-semibold text-sm {{ $statusColors[$surat->status->value] ?? 'bg-slate-100 text-slate-700' }}">
            Status: {{ $surat->status->label() }}
        </div>
    </div>

    <!-- Error/Success Messages -->
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Data & Dokumen -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Data Pemohon -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
                    <h2 class="font-bold text-slate-900 dark:text-white">Data Pemohon</h2>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6">
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Nama Pemohon</p>
                        <p class="font-medium text-slate-900 dark:text-white">{{ $surat->nama_pemohon }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">NIK</p>
                        <p class="font-medium text-slate-900 dark:text-white">{{ $surat->nik_pemohon }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">No HP/WA</p>
                        <p class="font-medium text-slate-900 dark:text-white">{{ $surat->no_hp_pemohon ?? '-' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Alamat</p>
                        <p class="font-medium text-slate-900 dark:text-white">{{ $surat->alamat_pemohon }}</p>
                    </div>
                    <div class="sm:col-span-2 pt-4 border-t border-slate-100 dark:border-slate-700">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Keperluan</p>
                        <p class="font-medium text-slate-900 dark:text-white">{{ $surat->keperluan }}</p>
                    </div>
                    @if($surat->catatan_pemohon)
                    <div class="sm:col-span-2">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Catatan Pemohon</p>
                        <p class="font-medium text-slate-900 dark:text-white">{{ $surat->catatan_pemohon }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Dokumen Lampiran -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
                    <h2 class="font-bold text-slate-900 dark:text-white">Dokumen Lampiran ({{ $surat->dokumens->count() }})</h2>
                </div>
                <div class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($surat->dokumens as $dok)
                    <div class="flex items-center gap-4 px-6 py-3">
                        <svg class="w-8 h-8 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ $dok->nama_dokumen }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $dok->file_name }}</p>
                        </div>
                        <a href="{{ Storage::url($dok->file_path) }}" target="_blank" class="px-3 py-1.5 text-xs font-medium bg-blue-50 hover:bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 dark:text-blue-400 rounded-lg transition-colors">
                            Buka / Download
                        </a>
                    </div>
                    @empty
                    <div class="p-6 text-center text-sm text-slate-500 dark:text-slate-400">
                        Tidak ada dokumen lampiran.
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Workflow Approval -->
            @if($surat->approvalWorkflow && $surat->approvalWorkflow->stages->count() > 0)
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
                    <h2 class="font-bold text-slate-900 dark:text-white">Alur Persetujuan (Workflow)</h2>
                </div>
                <div class="p-6 space-y-4">
                    @foreach($surat->approvalWorkflow->stages as $stage)
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 text-sm font-bold {{ $stage->action === 'pending' ? 'bg-slate-100 text-slate-500' : ($stage->action === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                            {{ $loop->iteration }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-sm text-slate-900 dark:text-white">{{ $stage->stage?->label() }}</p>
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $stage->action === 'pending' ? 'bg-slate-100 text-slate-500' : ($stage->action === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $stage->action }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                {{ $stage->user?->name ?? 'Menunggu proses' }} 
                                @if($stage->actioned_at) • {{ $stage->actioned_at->format('d M Y H:i') }} @endif
                            </p>
                            @if($stage->catatan)
                            <div class="mt-2 bg-slate-50 dark:bg-slate-900/50 p-2.5 rounded-lg text-xs text-slate-600 dark:text-slate-300">
                                <span class="font-medium text-slate-700 dark:text-slate-200">Catatan:</span> {{ $stage->catatan }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        <!-- Kolom Kanan: Aksi Form -->
        <div class="space-y-6">
            
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
                    <h2 class="font-bold text-slate-900 dark:text-white">Aksi & Proses</h2>
                </div>
                <div class="p-6">
                    
                    @if($surat->status->value === 'diajukan')
                        <!-- Tahap 1: Verifikasi Berkas -->
                        <div class="space-y-4">
                            <p class="text-sm text-slate-600 dark:text-slate-300">Periksa seluruh kelengkapan dokumen. Apakah berkas sudah valid?</p>
                            
                            <!-- Verifikasi Valid -->
                            <form action="{{ route('admin.layanan.surat.update-status', $surat->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="diverifikasi">
                                <button type="submit" class="w-full bg-cyan-600 hover:bg-cyan-700 text-white font-medium py-2.5 rounded-lg transition-colors text-sm mb-2">
                                    Berkas Valid & Verifikasi
                                </button>
                            </form>
                            
                            <!-- Revisi/Tolak -->
                            <form action="{{ route('admin.layanan.surat.update-status', $surat->id) }}" method="POST" class="border-t border-slate-100 dark:border-slate-700 pt-4 mt-4">
                                @csrf @method('PUT')
                                <div class="mb-3">
                                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Catatan Kekurangan/Penolakan <span class="text-red-500">*</span></label>
                                    <textarea name="catatan" rows="3" required class="w-full text-sm rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50" placeholder="Jelaskan alasan revisi atau penolakan..."></textarea>
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit" name="status" value="revisi" class="flex-1 bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium py-2 rounded-lg transition-colors text-sm">
                                        Minta Revisi
                                    </button>
                                    <button type="submit" name="status" value="ditolak" onclick="return confirm('Tolak permohonan ini secara permanen?')" class="flex-1 bg-red-100 hover:bg-red-200 text-red-700 font-medium py-2 rounded-lg transition-colors text-sm">
                                        Tolak Permohonan
                                    </button>
                                </div>
                            </form>
                        </div>

                    @elseif($surat->status->value === 'diverifikasi')
                        <!-- Tahap 2: Proses & Beri Nomor Surat -->
                        <form action="{{ route('admin.layanan.surat.update-status', $surat->id) }}" method="POST" class="space-y-4">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="diproses">
                            
                            <div>
                                <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Nomor Surat (Bisa diisi nanti)</label>
                                <input type="text" name="nomor_surat" value="{{ $surat->nomor_surat }}" class="w-full text-sm rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50" placeholder="000/000/DS/2026">
                            </div>
                            
                            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2.5 rounded-lg transition-colors text-sm">
                                Proses & Cetak Draf
                            </button>
                        </form>

                    @elseif($surat->status->value === 'diproses')
                        <!-- Tahap 3: Ajukan Persetujuan (Workflow) -->
                        <form action="{{ route('admin.layanan.surat.update-status', $surat->id) }}" method="POST" class="space-y-4">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="menunggu_persetujuan">
                            
                            <div>
                                <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Pastikan Nomor Surat Telah Diisi</label>
                                <input type="text" name="nomor_surat" value="{{ $surat->nomor_surat }}" required class="w-full text-sm rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50">
                            </div>

                            <div class="bg-orange-50 dark:bg-orange-900/20 p-3 rounded-lg text-sm text-orange-800 dark:text-orange-400 mb-2">
                                Permohonan akan masuk ke antrean Kepala Desa/Sekdes untuk ditandatangani.
                            </div>
                            
                            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-2.5 rounded-lg transition-colors text-sm">
                                Ajukan Persetujuan
                            </button>
                        </form>

                    @elseif($surat->status->value === 'menunggu_persetujuan')
                        <!-- Tahap 4: Approval (Role base) -->
                        @if(auth()->user()->hasAnyRole(['super_admin', 'kepala_desa', 'sekretaris_desa']))
                            <form action="{{ route('admin.layanan.surat.approve', $surat->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Persetujuan Sebagai</label>
                                    <select name="action" class="w-full text-sm rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50">
                                        <option value="approved">Setujui & Tandatangani</option>
                                        <option value="rejected">Tolak</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Catatan (Opsional)</label>
                                    <textarea name="catatan" rows="2" class="w-full text-sm rounded-lg border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50" placeholder="Tinggalkan catatan..."></textarea>
                                </div>
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 rounded-lg transition-colors text-sm">
                                    Proses Persetujuan
                                </button>
                            </form>
                        @else
                            <div class="p-4 bg-slate-50 dark:bg-slate-900/50 rounded-lg text-center text-sm text-slate-500 dark:text-slate-400">
                                Menunggu persetujuan dari pimpinan (Kades/Sekdes). Anda tidak memiliki akses untuk menyetujui.
                            </div>
                        @endif

                    @elseif($surat->status->value === 'selesai')
                        <!-- Tahap 5: Selesai -->
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <h3 class="font-bold text-slate-900 dark:text-white">Permohonan Selesai</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 mb-4">Surat telah diterbitkan dan memiliki QR Code verifikasi.</p>
                            <a href="{{ route('pelayanan.surat.pdf', $surat->id) }}" target="_blank" class="inline-flex justify-center w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-lg transition-colors text-sm">
                                Download Surat PDF
                            </a>
                        </div>
                    @else
                        <div class="p-4 text-center text-sm text-slate-500">
                            Tidak ada aksi yang bisa dilakukan pada status ini.
                        </div>
                    @endif

                </div>
            </div>

            <!-- Download PDF Admin (Preview) -->
            @if(in_array($surat->status->value, ['diproses', 'menunggu_persetujuan']))
            <a href="{{ route('pelayanan.surat.pdf', $surat->id) }}" target="_blank" class="flex items-center justify-center gap-2 w-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-medium py-3 rounded-xl transition-colors border border-slate-200 dark:border-slate-600 text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Preview Cetak Surat
            </a>
            @endif

        </div>

    </div>
</x-admin-layout>
