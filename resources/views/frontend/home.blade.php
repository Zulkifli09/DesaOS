<x-public-layout>
<x-slot name="title">Beranda</x-slot>

    <!-- Emergency Announcement Widget -->
    @if(isset($emergencyAnnouncements) && $emergencyAnnouncements->count() > 0)
    <div class="fixed top-20 left-0 right-0 z-40 bg-red-600 text-white shadow-lg border-b border-red-700 animate-pulse">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center flex-1">
                    <span class="flex p-2 rounded-lg bg-red-700">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </span>
                    <p class="ml-3 font-medium text-white">
                        <span class="md:hidden">Peringatan Darurat: {{ Str::limit($emergencyAnnouncements->first()->title, 30) }}</span>
                        <span class="hidden md:inline"><strong>Peringatan Darurat!</strong> {{ $emergencyAnnouncements->first()->title }}</span>
                    </p>
                </div>
                <div class="order-3 mt-2 flex-shrink-0 w-full sm:order-2 sm:mt-0 sm:w-auto">
                    <a href="{{ route('pengumuman.show', $emergencyAnnouncements->first()->slug) }}" class="flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-red-600 bg-white hover:bg-red-50">
                        Cek Info
                    </a>
                </div>
                <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-2">
                    <button type="button" class="-mr-1 flex p-2 rounded-md hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-white" onclick="this.parentElement.parentElement.parentElement.parentElement.style.display='none'">
                        <span class="sr-only">Tutup</span>
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Hero Section -->
    <section class="relative h-screen min-h-[600px] w-full overflow-hidden bg-slate-900 clip-path-slant flex items-center">
        <!-- Background Overlay -->
        <div class="absolute inset-0 z-0">
            <!-- Simulated Parallax / Heavy Image Background -->
            <div class="absolute inset-0 bg-emerald-900/60 mix-blend-multiply z-10"></div>
            <img src="https://images.unsplash.com/photo-1620023648496-d2ef43c3f915?q=80&w=2070&auto=format&fit=crop" 
                 alt="Village Hero" 
                 class="h-full w-full object-cover"
                 x-data x-intersect="$el.classList.add('scale-105', 'transition-transform', 'duration-[10000ms]')" />
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center"
             x-data="{ shown: false }" x-intersect.once="shown = true">
            <div class="max-w-4xl mx-auto transition-all duration-1000 translate-y-8 opacity-0"
                 :class="shown && '!translate-y-0 !opacity-100'">
                <span class="inline-block py-1 px-3 rounded-full bg-emerald-500/20 text-emerald-300 backdrop-blur-sm text-sm font-semibold mb-6 border border-emerald-500/30">
                    Sistem Cerdas Penggerak Desa
                </span>
                <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tight mb-8 font-outfit drop-shadow-lg leading-tight">
                    Membangun Desa, <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-200">Menghidupkan Bangsa.</span>
                </h1>
                <p class="text-lg md:text-xl text-slate-200 mb-10 max-w-2xl mx-auto drop-shadow-md">
                    Temukan segala informasi, potensi, dan kemudahan pelayanan administrasi Desa melalui genggaman Anda.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="#services" class="w-full sm:w-auto px-8 py-4 rounded-full bg-emerald-600 text-white font-semibold hover:bg-emerald-500 transition-all shadow-[0_0_20px_rgba(5,150,105,0.4)] hover:shadow-[0_0_30px_rgba(5,150,105,0.6)] transform hover:-translate-y-1">
                        Jelajahi Layanan
                    </a>
                    <a href="{{ route('potensi.index') }}" class="w-full sm:w-auto px-8 py-4 rounded-full bg-white/10 text-white font-semibold backdrop-blur-md hover:bg-white/20 transition-all border border-white/20 transform hover:-translate-y-1">
                        Lihat Potensi Desa
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-16 left-1/2 -translate-x-1/2 z-10 animate-bounce">
            <a href="#services" class="text-white/70 hover:text-white flex flex-col items-center">
                <span class="text-xs font-semibold tracking-widest uppercase mb-2">Scroll</span>
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </a>
        </div>
    </section>

    <!-- Quick Service Section -->
    <section id="services" class="py-24 bg-slate-50 relative -mt-10 z-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Service 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-emerald-100 transition-all duration-300 group transform hover:-translate-y-2"
                     x-data="{ shown: false }" x-intersect.once="shown = true"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" style="transition: all 0.7s ease-out 0ms;">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Surat Pengantar</h3>
                    <p class="text-slate-500 text-sm">Ajukan pembuatan surat pengantar RT/RW secara online tanpa harus antre.</p>
                </div>
                <!-- Service 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-emerald-100 transition-all duration-300 group transform hover:-translate-y-2"
                     x-data="{ shown: false }" x-intersect.once="shown = true"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" style="transition: all 0.7s ease-out 100ms;">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Lapor Warga</h3>
                    <p class="text-slate-500 text-sm">Sistem pelaporan aspirasi, keluhan, dan darurat langsung ke perangkat desa.</p>
                </div>
                <!-- Service 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-emerald-100 transition-all duration-300 group transform hover:-translate-y-2"
                     x-data="{ shown: false }" x-intersect.once="shown = true"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" style="transition: all 0.7s ease-out 200ms;">
                    <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-amber-600 group-hover:text-white transition-all">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Transparansi Dana</h3>
                    <p class="text-slate-500 text-sm">Akses terbuka informasi APBDES dan realisasi pembangunan infrastruktur.</p>
                </div>
                <!-- Service 4 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-emerald-100 transition-all duration-300 group transform hover:-translate-y-2"
                     x-data="{ shown: false }" x-intersect.once="shown = true"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'" style="transition: all 0.7s ease-out 300ms;">
                    <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Lapak UMKM</h3>
                    <p class="text-slate-500 text-sm">Direktori produk unggulan desa dari BUMDes dan masyarakat lokal.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Preview -->
    <section class="py-24 bg-white relative">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12" x-data="{ shown: false }" x-intersect.once="shown = true">
                <div class="max-w-2xl transition-all duration-700" :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-10'">
                    <h2 class="text-3xl md:text-4xl font-bold font-outfit text-slate-900 mb-4">Kabar <span class="text-emerald-600">Terbaru</span></h2>
                    <p class="text-slate-500 text-lg">Ikuti perkembangan, berita, dan pengumuman terbaru seputar Desa.</p>
                </div>
                <div class="mt-6 md:mt-0 transition-all duration-700 delay-200" :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-10'">
                    <a href="#" class="inline-flex items-center gap-2 font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                        Lihat Semua Berita 
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($latestNews as $index => $article)
                    <article class="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col h-full"
                             x-data="{ shown: false }" x-intersect.once="shown = true"
                             :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'" style="transition: all 0.7s ease-out {{ $index * 150 }}ms;">
                        <div class="relative h-56 overflow-hidden bg-slate-200">
                            @if($article->cover_image)
                                <img src="{{ Storage::url($article->cover_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400">No Image</div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-sm px-3 py-1 text-xs font-bold text-emerald-700 rounded-full uppercase tracking-wider">
                                    {{ $article->category->name }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex items-center gap-4 text-xs text-slate-500 mb-3">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    {{ $article->published_at->format('d M Y') }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    {{ $article->user->name }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-3 leading-snug group-hover:text-emerald-600 transition-colors">
                                <a href="#">{{ $article->title }}</a>
                            </h3>
                            <p class="text-slate-600 text-sm line-clamp-3 mb-6 flex-grow">
                                {{ Str::limit(strip_tags($article->content), 120) }}
                            </p>
                            <a href="#" class="mt-auto text-emerald-600 font-semibold text-sm group-hover:text-emerald-700 flex items-center gap-1">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 py-12 text-center text-slate-500 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                        Belum ada berita yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Agenda & UMKM Placeholder Preview (Milestone 14 & 17) -->
    <section class="py-24 bg-slate-900 text-white relative overflow-hidden">
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 -mr-32 -mt-32 w-96 h-96 rounded-full bg-emerald-600/20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-32 -mb-32 w-96 h-96 rounded-full bg-blue-600/20 blur-3xl"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <!-- Agenda Preview -->
                <div x-data="{ shown: false }" x-intersect.once="shown = true"
                     :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-12'" class="transition-all duration-1000">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-12 h-12 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-400 backdrop-blur-sm border border-emerald-500/30">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <h2 class="text-3xl font-bold font-outfit">Agenda Desa</h2>
                    </div>
                    
                    <div class="space-y-4">
                        <!-- Mockup Event 1 -->
                        <div class="flex gap-4 p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors group cursor-pointer backdrop-blur-sm">
                            <div class="flex flex-col items-center justify-center w-16 h-16 rounded-lg bg-emerald-600 text-white flex-shrink-0">
                                <span class="text-xs font-medium uppercase tracking-wider">Agt</span>
                                <span class="text-2xl font-bold leading-none">17</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-white group-hover:text-emerald-400 transition-colors">Perayaan HUT Kemerdekaan RI ke-81</h3>
                                <div class="flex items-center gap-4 mt-2 text-sm text-slate-400">
                                    <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> 08:00 - Selesai</span>
                                    <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg> Lapangan Desa</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Mockup Event 2 -->
                        <div class="flex gap-4 p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors group cursor-pointer backdrop-blur-sm">
                            <div class="flex flex-col items-center justify-center w-16 h-16 rounded-lg bg-slate-800 text-slate-300 flex-shrink-0">
                                <span class="text-xs font-medium uppercase tracking-wider">Sep</span>
                                <span class="text-2xl font-bold leading-none">05</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-white group-hover:text-emerald-400 transition-colors">Musyawarah Perencanaan Pembangunan Desa</h3>
                                <div class="flex items-center gap-4 mt-2 text-sm text-slate-400">
                                    <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> 09:00 - 12:00</span>
                                    <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg> Balai Desa</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- UMKM / Potensi Preview -->
                <div x-data="{ shown: false }" x-intersect.once="shown = true"
                     :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-12'" class="transition-all duration-1000 delay-200">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-12 h-12 rounded-lg bg-blue-500/20 flex items-center justify-center text-blue-400 backdrop-blur-sm border border-blue-500/30">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        </div>
                        <h2 class="text-3xl font-bold font-outfit">Produk Unggulan</h2>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        @forelse($potentials as $pot)
                            <a href="{{ route('potensi.show', $pot->slug) }}" class="group relative rounded-xl overflow-hidden aspect-[4/3] block">
                                <img src="{{ Storage::url($pot->cover_image) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="{{ $pot->name }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent opacity-80 group-hover:opacity-100 transition-opacity"></div>
                                <div class="absolute bottom-0 left-0 p-4">
                                    <span class="bg-blue-600 text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider mb-2 inline-block">{{ $pot->category }}</span>
                                    <h3 class="text-white font-bold mb-1 leading-tight group-hover:text-blue-300 transition-colors">{{ $pot->name }}</h3>
                                    <p class="text-slate-300 text-xs truncate">{{ $pot->contact_name ?? $pot->location }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="col-span-2 text-slate-500 bg-white/5 border border-white/10 p-4 rounded-xl text-center">
                                Belum ada potensi desa.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Preview -->
    <section class="py-24 bg-slate-50 relative">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16" x-data="{ shown: false }" x-intersect.once="shown = true"
                 :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'" class="transition-all duration-700">
                <h2 class="text-3xl md:text-4xl font-bold font-outfit text-slate-900 mb-4">Galeri <span class="text-emerald-600">Desa</span></h2>
                <p class="text-slate-500 text-lg">Potret keindahan, kegiatan, dan pembangunan di lingkungan desa.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                @forelse($galleries as $index => $media)
                    <div class="group relative aspect-square md:aspect-[4/3] rounded-2xl overflow-hidden shadow-sm"
                         x-data="{ shown: false }" x-intersect.once="shown = true"
                         :class="shown ? 'opacity-100 scale-100' : 'opacity-0 scale-95'" style="transition: all 0.5s ease-out {{ $index * 100 }}ms;">
                        @if($media->type === 'image')
                            <img src="{{ Storage::url($media->media_path) }}" alt="{{ $media->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                        @else
                            <div class="w-full h-full bg-slate-900 flex items-center justify-center">
                                <span class="text-white text-xs font-bold uppercase">{{ $media->type }}</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4 md:p-6 backdrop-blur-[2px]">
                            <h4 class="text-white font-semibold truncate">{{ $media->title }}</h4>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-500">
                        Belum ada foto di Galeri.
                    </div>
                @endforelse
            </div>
            
            <div class="mt-12 text-center">
                <a href="{{ route('galeri.index') }}" class="inline-flex items-center justify-center px-8 py-3 rounded-full border-2 border-emerald-600 text-emerald-600 font-semibold hover:bg-emerald-600 hover:text-white transition-colors">
                    Lihat Seluruh Galeri
                </a>
            </div>
        </div>
    </section>

    <!-- Map Preview -->
    <section class="h-96 w-full relative bg-slate-200">
        <!-- Placeholder for actual Google Maps Iframe -->
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126920.24098656627!2d106.75883296181954!3d-6.229746497551009!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x100c5e82dd4b820!2sJakarta!5e0!3m2!1sen!2sid!4v1689234856037!5m2!1sen!2sid" 
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="grayscale contrast-125 opacity-80">
        </iframe>
        
        <div class="absolute inset-0 pointer-events-none shadow-[inset_0_0_50px_rgba(0,0,0,0.1)]"></div>
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none">
            <div class="bg-white/90 backdrop-blur-md px-6 py-4 rounded-2xl shadow-xl flex items-center gap-4 border border-emerald-100">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-lg">Kantor Kepala Desa</h3>
                    <p class="text-slate-500 text-sm">Pusat Pelayanan Terpadu</p>
                </div>
            </div>
        </div>
    </section>

</x-public-layout>
