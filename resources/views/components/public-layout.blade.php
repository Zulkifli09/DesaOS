<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'DesaOS' }} - Sistem Informasi & Pelayanan Desa</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Website Resmi Pemerintah Desa. Pusat informasi, layanan publik, berita, potensi, dan transparansi anggaran desa untuk masyarakat.">
    <meta name="keywords" content="Desa, Pemerintah Desa, DesaOS, Pelayanan Publik, Sistem Informasi Desa, Potensi Desa, Berita Desa">
    <meta name="author" content="Pemerintah Desa">
    
    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="{{ $title ?? 'DesaOS' }} - Sistem Informasi Desa">
    <meta property="og:description" content="Portal Layanan Digital dan Informasi Resmi Pemerintah Desa. Transparan, Cepat, dan Mudah.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|outfit:400,500,600,700,800" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .clip-path-slant { clip-path: polygon(0 0, 100% 0, 100% 100%, 0 calc(100% - 5vw)); }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Loading Animation -->
    <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 800)" 
         x-show="loading" x-transition.opacity.duration.500ms
         class="fixed inset-0 z-[100] flex items-center justify-center bg-white">
        <div class="relative flex h-24 w-24 items-center justify-center">
            <div class="absolute inset-0 rounded-full border-4 border-emerald-100"></div>
            <div class="absolute inset-0 rounded-full border-4 border-emerald-600 border-t-transparent animate-spin"></div>
            <div class="text-xl font-bold font-outfit text-emerald-600">D</div>
        </div>
    </div>

    <!-- Navigation -->
    <header class="fixed top-0 z-50 w-full transition-all duration-300" 
            :class="scrolled ? 'bg-white/90 backdrop-blur-md shadow-sm py-3' : 'bg-transparent py-5'">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white font-bold text-2xl transition-transform group-hover:scale-105 shadow-lg shadow-emerald-600/30">D</div>
                    <span class="text-2xl font-bold tracking-tight font-outfit" :class="scrolled ? 'text-slate-900' : 'text-white'">Desa<span class="text-emerald-500">OS</span></span>
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('profil') }}" class="text-sm font-semibold transition-colors" :class="scrolled ? 'text-slate-600 hover:text-emerald-600' : 'text-white/90 hover:text-white'">Profil</a>
                    
                    <!-- Dropdown Layanan -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="text-sm font-semibold transition-colors flex items-center gap-1" :class="scrolled ? 'text-slate-600 hover:text-emerald-600' : 'text-white/90 hover:text-white'">
                            Informasi Publik
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="open" x-transition x-cloak class="absolute left-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50">
                            <a href="{{ route('statistik.index') }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 font-medium">Statistik Desa</a>
                            <a href="{{ route('dokumen.index') }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 font-medium">Download Center</a>
                            <a href="{{ route('faq.index') }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 font-medium">Tanya Jawab (FAQ)</a>
                        </div>
                    </div>

                    <a href="{{ route('potensi.index') }}" class="text-sm font-semibold transition-colors" :class="scrolled ? 'text-slate-600 hover:text-emerald-600' : 'text-white/90 hover:text-white'">Potensi</a>
                    <a href="{{ route('umkm.index') }}" class="text-sm font-semibold transition-colors" :class="scrolled ? 'text-slate-600 hover:text-emerald-600' : 'text-white/90 hover:text-white'">UMKM</a>
                    <a href="{{ route('galeri.index') }}" class="text-sm font-semibold transition-colors" :class="scrolled ? 'text-slate-600 hover:text-emerald-600' : 'text-white/90 hover:text-white'">Galeri</a>
                    
                    <!-- Dropdown Kabar -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button class="text-sm font-semibold transition-colors flex items-center gap-1" :class="scrolled ? 'text-slate-600 hover:text-emerald-600' : 'text-white/90 hover:text-white'">
                            Kabar Desa
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        <div x-show="open" x-transition x-cloak class="absolute left-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50">
                            <a href="{{ route('berita.index') }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 font-medium">Berita Terbaru</a>
                            <a href="{{ route('pengumuman.index') }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-emerald-50 hover:text-emerald-600 font-medium">Pengumuman</a>
                        </div>
                    </div>

                    <a href="{{ route('kontak.index') }}" class="text-sm font-semibold transition-colors" :class="scrolled ? 'text-slate-600 hover:text-emerald-600' : 'text-white/90 hover:text-white'">Kontak</a>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-full bg-emerald-600 px-6 py-2 text-sm font-semibold text-white transition-all hover:bg-emerald-500 hover:shadow-lg hover:shadow-emerald-500/30">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-full px-6 py-2 text-sm font-semibold transition-all" 
                               :class="scrolled ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'bg-white/10 text-white hover:bg-white/20 backdrop-blur-sm'">Log in</a>
                        @endauth
                    @endif
                </nav>

                <!-- Mobile Menu Button -->
                <div class="flex md:hidden items-center">
                    <button type="button" class="text-slate-500 p-2" :class="scrolled ? 'text-slate-900' : 'text-white'">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer Premium -->
    <footer class="bg-slate-900 pt-20 pb-10 text-slate-300 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 h-64 w-64 rounded-full bg-emerald-600/20 blur-3xl"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-6">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500 text-white font-bold text-2xl">D</div>
                        <span class="text-2xl font-bold tracking-tight font-outfit text-white">Desa<span class="text-emerald-500">OS</span></span>
                    </a>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Platform digital pelayanan dan informasi desa modern terintegrasi, membawa kemajuan teknologi hingga ke pelosok negeri.
                    </p>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-6">Navigasi</h3>
                    <ul class="space-y-4 text-sm">
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Profil Desa</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Pemerintahan</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Layanan Publik</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Data Desa</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-6">Media & Informasi</h3>
                    <ul class="space-y-4 text-sm">
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Berita Terkini</a></li>
                        <li><a href="{{ route('pengumuman.index') }}" class="hover:text-emerald-400 transition-colors">Pengumuman</a></li>
                        <li><a href="{{ route('galeri.index') }}" class="hover:text-emerald-400 transition-colors">Galeri Desa</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition-colors">Agenda Kegiatan</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-6">Kontak</h3>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            <span>Jl. Balai Desa No. 1, Kecamatan Makmur, Kabupaten Gemilang</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.48-4.08-7.074-6.97l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                            <span>(021) 1234-5678</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                            <span>halo@desaos.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row items-center justify-between text-sm text-slate-500">
                <p>&copy; {{ date('Y') }} DesaOS Enterprise. All rights reserved.</p>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
