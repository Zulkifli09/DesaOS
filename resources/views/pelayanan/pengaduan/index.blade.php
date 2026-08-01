<x-pelayanan-layout title="Layanan Pengaduan">
    <div class="p-6">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="font-outfit font-bold text-2xl text-slate-900">Pengaduan Masyarakat</h1>
            <p class="text-slate-500 mt-1">Sampaikan laporan, keluhan, atau aspirasi Anda langsung kepada Pemerintah Desa.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- CTA Box --}}
            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-8 text-white relative overflow-hidden shadow-lg shadow-indigo-500/20 flex flex-col justify-center">
                <div class="absolute inset-0 opacity-10 pointer-events-none">
                    <svg class="absolute right-0 bottom-0 w-64 h-64 transform translate-x-1/3 translate-y-1/3" fill="currentColor" viewBox="0 0 100 100">
                        <path d="M0,50 a50,50 0 1,0 100,0 a50,50 0 1,0 -100,0" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <h2 class="font-outfit font-bold text-2xl mb-2">Punya Keluhan atau Saran?</h2>
                    <p class="text-indigo-100 mb-6 max-w-sm leading-relaxed">Jangan ragu untuk melapor. Kami menjamin kerahasiaan identitas Anda (Opsional) dan menindaklanjuti setiap laporan yang masuk.</p>
                    <a href="{{ route('pelayanan.pengaduan.create') }}" class="inline-flex items-center justify-center gap-2 bg-white text-indigo-700 px-6 py-3 rounded-xl font-semibold hover:bg-indigo-50 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                        Buat Pengaduan Sekarang
                    </a>
                </div>
            </div>

            {{-- Cara Kerja --}}
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
                <h3 class="font-outfit font-bold text-lg text-slate-900 mb-4">Cara Kerja Layanan Pengaduan</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold shrink-0 text-sm">1</div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">Tulis Laporan</p>
                            <p class="text-slate-500 text-xs mt-0.5">Laporkan keluhan dengan jelas, sertakan foto dan lokasi kejadian.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center font-bold shrink-0 text-sm">2</div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">Proses Verifikasi</p>
                            <p class="text-slate-500 text-xs mt-0.5">Petugas akan memverifikasi dan meneruskan laporan ke pihak terkait.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center font-bold shrink-0 text-sm">3</div>
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">Tindak Lanjut & Selesai</p>
                            <p class="text-slate-500 text-xs mt-0.5">Laporan ditindaklanjuti dan Anda dapat memantau prosesnya hingga selesai.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kategori Grid --}}
        <div>
            <h2 class="font-outfit font-bold text-lg text-slate-900 mb-4">Kategori Pengaduan</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($kategoris as $kat)
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center group hover:border-indigo-300 transition-colors">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-xl mx-auto mb-3 group-hover:bg-indigo-50 transition-colors">
                        @if($kat->value === 'infrastruktur') 🛣️
                        @elseif($kat->value === 'pelayanan') 👥
                        @elseif($kat->value === 'keamanan') 🛡️
                        @elseif($kat->value === 'kesehatan') 🏥
                        @elseif($kat->value === 'lingkungan') 🌳
                        @elseif($kat->value === 'sosial') 🤝
                        @else 📝 @endif
                    </div>
                    <h3 class="font-semibold text-slate-800 text-sm">{{ $kat->label() }}</h3>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</x-pelayanan-layout>
