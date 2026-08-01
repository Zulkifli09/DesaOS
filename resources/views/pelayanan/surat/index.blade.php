<x-pelayanan-layout title="Pilih Jenis Surat">
    <div class="p-6">
        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="font-outfit font-bold text-2xl text-slate-900">Surat Online</h1>
            <p class="text-slate-500 mt-1">Pilih jenis surat yang Anda butuhkan. Pastikan Anda telah menyiapkan dokumen persyaratan.</p>
        </div>

        {{-- Service Cards Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($jenisSurats as $jenis)
            @php $template = $templates->firstWhere('jenis_surat.value', $jenis->value); @endphp
            <a href="{{ route('pelayanan.surat.create', $jenis->value) }}" 
               class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-xl hover:border-blue-300 hover:-translate-y-1 transition-all group cursor-pointer">
                
                {{-- Icon --}}
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center text-3xl mb-4 group-hover:scale-110 transition-transform">
                    {{ $jenis->icon() }}
                </div>

                {{-- Content --}}
                <h3 class="font-outfit font-bold text-slate-900 text-lg group-hover:text-blue-700 transition-colors">{{ $jenis->label() }}</h3>
                <p class="text-slate-500 text-sm mt-1 leading-relaxed">{{ $jenis->description() }}</p>

                {{-- Meta --}}
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="flex items-center gap-1 text-xs text-slate-500">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        ±{{ $template?->estimasi_hari ?? $jenis->estimasiHari() }} hari kerja
                    </span>
                    <span class="inline-flex items-center gap-1 text-blue-600 text-sm font-medium group-hover:gap-2 transition-all">
                        Ajukan
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </div>

                {{-- Requirements preview --}}
                @if($template?->persyaratan)
                <div class="mt-3 hidden group-hover:block">
                    <p class="text-xs font-semibold text-slate-500 mb-1">Persyaratan:</p>
                    <ul class="space-y-0.5">
                        @foreach(array_slice($template->persyaratan, 0, 3) as $req)
                        <li class="text-xs text-slate-500 flex items-start gap-1">
                            <svg class="w-3 h-3 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $req }}
                        </li>
                        @endforeach
                        @if(count($template->persyaratan) > 3)
                        <li class="text-xs text-slate-400">+{{ count($template->persyaratan) - 3 }} lainnya...</li>
                        @endif
                    </ul>
                </div>
                @endif
            </a>
            @endforeach
        </div>

        {{-- Info Box --}}
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-2xl p-6">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-blue-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="font-semibold text-blue-900">Cara Mengajukan Surat</h3>
                    <ol class="mt-2 space-y-1 text-sm text-blue-700 list-decimal list-inside">
                        <li>Pilih jenis surat yang dibutuhkan</li>
                        <li>Isi formulir dengan data yang benar dan lengkap</li>
                        <li>Upload dokumen persyaratan (foto/scan)</li>
                        <li>Simpan sebagai draft atau langsung ajukan</li>
                        <li>Pantau status permohonan di halaman Riwayat</li>
                        <li>Download surat ketika status sudah "Selesai"</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</x-pelayanan-layout>
