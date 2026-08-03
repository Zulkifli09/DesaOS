<x-admin-layout>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">WhatsApp Gateway</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola koneksi WhatsApp untuk Notifikasi dan Bot.</p>
        </div>
    </div>

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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Status Card -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 flex justify-between items-center">
                <h2 class="font-bold text-slate-900 dark:text-white">Status Koneksi</h2>
                
                @if($isConnected)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                        Connected
                    </span>
                @elseif($status === 'qr')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                        Menunggu Scan
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                        Offline
                    </span>
                @endif
            </div>
            
            <div class="p-6 text-center">
                @if($isConnected)
                    <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Gateway Aktif</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 mb-6">WhatsApp Gateway berhasil terhubung dan siap memproses pesan.</p>
                    
                    <form action="{{ route('admin.whatsapp.logout') }}" method="POST">
                        @csrf
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin memutuskan koneksi? Sesi akan dihapus dan Anda perlu scan QR ulang.')" class="bg-red-50 hover:bg-red-100 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 font-medium px-4 py-2 rounded-lg text-sm transition-colors border border-red-200 dark:border-red-800">
                            Putuskan Koneksi (Logout)
                        </button>
                    </form>
                
                @elseif($status === 'qr' && $qrCode)
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Scan QR Code</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Buka WhatsApp di HP Anda > Perangkat Taut > Tautkan Perangkat. Arahkan kamera ke QR Code di bawah ini.</p>
                        
                        <!-- Simple library to render QR from text using Google Chart API or similar -->
                        <div class="inline-block p-4 bg-white border-4 border-slate-100 rounded-2xl shadow-sm">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode($qrCode) }}" alt="QR Code" class="w-64 h-64">
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-4">* Refresh halaman ini setelah melakukan scan untuk memperbarui status.</p>
                    <a href="{{ route('admin.whatsapp.index') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition-colors">
                        Refresh Status
                    </a>

                @else
                    <div class="w-20 h-20 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Gateway Offline / Tidak Terhubung</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 mb-6">Service Node.js mungkin belum berjalan atau konfigurasi API Key salah.</p>
                    
                    <a href="{{ route('admin.whatsapp.index') }}" class="inline-block bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 font-medium px-4 py-2 rounded-lg text-sm transition-colors">
                        Cek Ulang Status
                    </a>
                @endif
            </div>
        </div>

        <!-- Info / Petunjuk -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
                <h2 class="font-bold text-slate-900 dark:text-white">Informasi Sistem</h2>
            </div>
            <div class="p-6 space-y-4 text-sm text-slate-600 dark:text-slate-400">
                <p><strong>WhatsApp Gateway</strong> menggunakan arsitektur Microservice berbasis Node.js dan Baileys.</p>
                <div class="bg-blue-50 dark:bg-blue-900/20 text-blue-800 dark:text-blue-400 p-4 rounded-xl border border-blue-100 dark:border-blue-900/30">
                    <h4 class="font-bold mb-1">Cara Mengaktifkan:</h4>
                    <ol class="list-decimal pl-4 space-y-1">
                        <li>Buka terminal server / lokal</li>
                        <li>Masuk ke folder <code>wa-gateway</code></li>
                        <li>Jalankan perintah <code>npm start</code></li>
                        <li>Kembali ke halaman ini dan scan QR Code</li>
                    </ol>
                </div>
                <p>Gateway ini bertugas:</p>
                <ul class="list-disc pl-4 space-y-1">
                    <li>Meneruskan pesan masuk warga ke server Laravel (Bot Logic).</li>
                    <li>Mengirim pesan notifikasi otomatis dari sistem ke warga (Misal: Surat Selesai).</li>
                    <li>Mengeksekusi fitur Broadcast pengumuman.</li>
                </ul>
                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <p class="text-xs">
                        Endpoint Gateway: <span class="font-mono bg-slate-100 dark:bg-slate-700 px-1 py-0.5 rounded">{{ config('whatsapp.gateway_url') }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
