<x-public-layout>
    <div class="py-12 bg-slate-50 min-h-screen flex items-center justify-center">
        <div class="max-w-xl w-full mx-auto px-4">
            
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-500/30">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold font-outfit text-slate-900">Verifikasi Dokumen</h1>
                <p class="text-slate-600 mt-2">Sistem Pemeriksaan Keaslian Dokumen Surat Desa</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <div class="bg-green-500 px-6 py-4 flex items-center justify-center gap-2">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-white font-bold text-lg tracking-wide">DOKUMEN VALID & RESMI</span>
                </div>
                
                <div class="p-6 md:p-8">
                    <div class="text-center border-b border-slate-100 pb-6 mb-6">
                        <h2 class="text-xl font-bold text-slate-900 mb-1">{{ $surat->jenis_surat?->label() }}</h2>
                        <p class="text-slate-500 font-mono">No: {{ $surat->nomor_surat }}</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-slate-500 mb-1">Diberikan kepada:</p>
                            <p class="font-bold text-slate-900 text-lg uppercase">{{ $surat->nama_pemohon }}</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                            <div>
                                <p class="text-xs text-slate-500">Tanggal Terbit</p>
                                <p class="font-medium text-slate-900">{{ $surat->tanggal_selesai?->translatedFormat('d F Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Penandatangan</p>
                                <p class="font-medium text-slate-900">Kepala Desa</p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <p class="text-xs text-slate-500">Keperluan</p>
                            <p class="font-medium text-slate-900 mt-1">{{ $surat->keperluan }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-6 py-4 text-center text-xs text-slate-500 border-t border-slate-100">
                    <p>Dokumen ini ditandatangani secara elektronik. Scan QR Code mengarahkan langsung ke halaman resmi ini.</p>
                    <p class="mt-1 font-semibold text-slate-400">© {{ date('Y') }} {{ config('app.name', 'DesaOS') }}</p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('home') }}" class="text-blue-600 font-medium hover:underline flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</x-public-layout>
