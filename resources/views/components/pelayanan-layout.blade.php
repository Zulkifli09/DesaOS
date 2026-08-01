@props(['title' => 'Layanan Digital'])

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — {{ config('app.name', 'DesaOS') }}</title>
    <meta name="description" content="Portal Layanan Digital Desa — Ajukan surat, laporkan pengaduan, pantau status secara online.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&family=inter:400,500,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">

    <!-- Top Navigation Bar -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-slate-200 shadow-sm">
        <div class="flex items-center justify-between h-16 px-4 lg:px-6">
            <!-- Logo + Toggle -->
            <div class="flex items-center gap-3">
                <button id="sidebar-toggle" class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <a href="{{ route('pelayanan.dashboard') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                    </div>
                    <div class="hidden sm:block">
                        <p class="font-outfit font-bold text-slate-900 text-base leading-tight">Portal Layanan</p>
                        <p class="text-xs text-slate-500 leading-none">{{ config('app.name', 'DesaOS') }}</p>
                    </div>
                </a>
            </div>

            <!-- Right: Notifications + User -->
            <div class="flex items-center gap-2">
                <!-- Notification Bell -->
                <a href="{{ route('pelayanan.notifikasi.index') }}" class="relative p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors" id="notif-bell">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span id="notif-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full min-w-5 h-5 px-1 flex items-center justify-center font-bold hidden">0</span>
                </a>

                <!-- User Dropdown -->
                <div class="relative group">
                    <button class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-100 transition-colors">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-bold shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-medium text-slate-800 max-w-28 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-400">Warga</p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 hidden md:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="absolute right-0 mt-1 w-52 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all z-50">
                        <div class="px-4 py-2 border-b border-slate-100 mb-1">
                            <p class="text-xs text-slate-400">Masuk sebagai</p>
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil Saya
                        </a>
                        <a href="{{ route('home') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Website Desa
                        </a>
                        <div class="border-t border-slate-100 mt-1 pt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="flex pt-16 min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed left-0 top-16 bottom-0 w-64 bg-white border-r border-slate-200 overflow-y-auto z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <nav class="p-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('pelayanan.dashboard') }}" 
                   class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('pelayanan.dashboard') 
                             ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-500/30' 
                             : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    Dashboard
                </a>

                <!-- Surat Section -->
                <div class="pt-4 pb-1 px-1">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3">Surat Online</p>
                </div>
                
                <a href="{{ route('pelayanan.surat.index') }}" 
                   class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('pelayanan.surat.index', 'pelayanan.surat.create') 
                             ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-500/30' 
                             : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Surat Baru
                </a>
                
                <a href="{{ route('pelayanan.surat.riwayat') }}" 
                   class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('pelayanan.surat.riwayat', 'pelayanan.surat.show') 
                             ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-500/30' 
                             : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Riwayat Surat
                </a>

                <!-- Pengaduan Section -->
                <div class="pt-4 pb-1 px-1">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3">Pengaduan</p>
                </div>
                
                <a href="{{ route('pelayanan.pengaduan.create') }}" 
                   class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('pelayanan.pengaduan.create') 
                             ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-500/30' 
                             : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    Buat Pengaduan
                </a>
                
                <a href="{{ route('pelayanan.pengaduan.riwayat') }}" 
                   class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('pelayanan.pengaduan.riwayat', 'pelayanan.pengaduan.show', 'pelayanan.pengaduan.index') 
                             ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-500/30' 
                             : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    Riwayat Pengaduan
                </a>

                <!-- Notifikasi -->
                <div class="pt-4 pb-1 px-1">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3">Akun</p>
                </div>
                
                <a href="{{ route('pelayanan.notifikasi.index') }}" 
                   class="group flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('pelayanan.notifikasi.*') 
                             ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-500/30' 
                             : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    Notifikasi
                    <span id="sidebar-badge" class="ml-auto bg-red-500 text-white text-xs rounded-full min-w-5 h-5 px-1 flex items-center justify-center font-bold hidden">0</span>
                </a>

                <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Website Desa
                </a>

                @if(auth()->user()->hasAnyRole(['super_admin','kepala_desa','sekretaris_desa','kasi','kaur','operator','petugas_pelayanan']))
                <div class="pt-4 pb-1 px-1">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider px-3">Admin</p>
                </div>
                <a href="{{ route('admin.layanan.surat.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-orange-50 hover:text-orange-700 transition-all">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Kelola Surat
                </a>
                <a href="{{ route('admin.layanan.pengaduan.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-slate-600 hover:bg-orange-50 hover:text-orange-700 transition-all">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                    </svg>
                    Kelola Pengaduan
                </a>
                @endif
            </nav>
        </aside>

        <!-- Sidebar Overlay (mobile) -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-30 hidden lg:hidden"></div>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 min-h-screen">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mx-6 mt-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-2xl shadow-sm">
                    <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="mx-6 mt-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-2xl shadow-sm">
                    <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="font-medium text-sm">{{ session('error') }}</p>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

    <script>
        // Sidebar toggle for mobile
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        sidebarToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

        // Notification badge auto-refresh
        async function updateNotifBadge() {
            try {
                const res = await fetch('{{ route('pelayanan.notifikasi.unread-count') }}', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!res.ok) return;
                const data = await res.json();
                const count = data.count || 0;
                
                ['notif-badge', 'sidebar-badge'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.textContent = count > 99 ? '99+' : count;
                        el.classList.toggle('hidden', count === 0);
                    }
                });
            } catch(e) {}
        }
        
        updateNotifBadge();
        setInterval(updateNotifBadge, 60000);
    </script>
</body>
</html>
