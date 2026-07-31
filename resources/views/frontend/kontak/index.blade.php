<x-public-layout>
    <x-slot name="title">Kontak & Layanan Desa</x-slot>

    <!-- Header Section -->
    <section class="pt-32 pb-16 bg-slate-900 overflow-hidden relative">
        <div class="absolute inset-0 z-0 opacity-20">
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-emerald-500 rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/2"></div>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center max-w-3xl">
            <span class="text-blue-400 font-bold uppercase tracking-wider text-sm mb-2 block">Hubungi Kami</span>
            <h1 class="text-4xl md:text-5xl font-bold font-outfit text-white mb-6 leading-tight">Kontak & Pusat Layanan</h1>
            <p class="text-slate-300 text-lg">Pemerintah Desa siap melayani Anda. Silakan hubungi kami melalui saluran resmi di bawah ini atau kunjungi kantor balai desa pada jam kerja.</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16 bg-slate-50 relative">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            
            @if(session('success'))
                <div class="mb-8 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-xl shadow-sm text-center font-medium" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 relative -mt-32 z-20">
                
                <!-- Left: Contact Form -->
                <div class="lg:w-2/5">
                    <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 p-8 border border-slate-100">
                        <h2 class="text-2xl font-bold font-outfit text-slate-900 mb-2">Kirim Pesan</h2>
                        <p class="text-slate-500 text-sm mb-8">Punya pertanyaan, kritik, atau saran? Tulis pesan Anda di sini.</p>
                        
                        <form action="{{ route('kontak.store') }}" method="POST" class="space-y-5">
                            @csrf
                            
                            <div>
                                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1">No. WhatsApp</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Email Aktif</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                                </div>
                            </div>
                            
                            <div>
                                <label for="subject" class="block text-sm font-semibold text-slate-700 mb-1">Subjek <span class="text-red-500">*</span></label>
                                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                                @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label for="message" class="block text-sm font-semibold text-slate-700 mb-1">Isi Pesan <span class="text-red-500">*</span></label>
                                <textarea name="message" id="message" rows="5" required class="w-full bg-slate-50 border border-slate-200 text-slate-900 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">{{ old('message') }}</textarea>
                                @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-xl transition-all shadow-lg shadow-blue-600/30 hover:shadow-xl hover:-translate-y-1">
                                Kirim Pesan Sekarang
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right: Info, Maps, Schedules -->
                <div class="lg:w-3/5 space-y-6">
                    
                    <!-- Quick Contacts Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 lg:pt-32">
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex items-start gap-4 hover:border-blue-300 transition-colors">
                            <div class="bg-blue-50 text-blue-600 p-4 rounded-xl shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 mb-1">Email Resmi</h3>
                                <p class="text-slate-600">pemdes@desa.go.id</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 flex items-start gap-4 hover:border-green-300 transition-colors">
                            <div class="bg-green-50 text-green-600 p-4 rounded-xl shrink-0">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.418-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.029 18.88c-1.161 0-2.305-.292-3.318-.844l-3.677.964.984-3.595c-.607-1.052-.927-2.246-.926-3.468.001-5.824 4.74-10.563 10.564-10.563 5.826 0 10.564 4.741 10.564 10.564 0 5.824-4.74 10.564-10.564 10.564z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 mb-1">WhatsApp Pelayanan</h3>
                                <p class="text-slate-600">+62 812-3456-7890</p>
                            </div>
                        </div>
                    </div>

                    <!-- Maps & Office Hours -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col md:flex-row">
                        <div class="md:w-1/2 p-6 md:p-8 bg-slate-900 text-white">
                            <h3 class="text-xl font-bold font-outfit mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Jam Pelayanan
                            </h3>
                            <ul class="space-y-4">
                                <li class="flex justify-between items-center border-b border-white/10 pb-3">
                                    <span class="text-slate-300">Senin - Kamis</span>
                                    <span class="font-semibold">08:00 - 15:00 WIB</span>
                                </li>
                                <li class="flex justify-between items-center border-b border-white/10 pb-3">
                                    <span class="text-slate-300">Jumat</span>
                                    <span class="font-semibold">08:00 - 11:30 WIB</span>
                                </li>
                                <li class="flex justify-between items-center border-b border-white/10 pb-3">
                                    <span class="text-slate-300">Sabtu - Minggu</span>
                                    <span class="font-semibold text-red-400">Tutup / Libur</span>
                                </li>
                            </ul>
                            <div class="mt-8 pt-6 border-t border-white/10">
                                <h4 class="font-bold mb-2">Alamat Kantor:</h4>
                                <p class="text-slate-400 leading-relaxed">Jl. Raya Desa No. 1, Kecamatan Contoh, Kabupaten Teladan, Provinsi Jawa Barat, 12345</p>
                            </div>
                        </div>
                        <div class="md:w-1/2 h-64 md:h-auto relative">
                            <!-- Dummy iframe Google Maps -->
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126907.08051750058!2d106.74549480390623!3d-6.283928299999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f1092e07ebcd%3A0xc62d85d778d97529!2sJakarta%20Selatan%2C%20Kota%20Jakarta%20Selatan%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1704283838123!5m2!1sid!2sid" width="100%" height="100%" style="border:0; position:absolute; top:0; left:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>

                    <!-- Emergency Contacts -->
                    <div class="bg-red-50 rounded-2xl p-6 md:p-8 border border-red-100 mt-6">
                        <h3 class="text-xl font-bold font-outfit text-red-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            Kontak Darurat (24 Jam)
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-white p-4 rounded-xl shadow-sm flex items-center justify-between">
                                <span class="font-semibold text-slate-700">Ambulan Desa</span>
                                <a href="tel:081234567891" class="text-red-600 font-bold hover:underline">0812-3456-7891</a>
                            </div>
                            <div class="bg-white p-4 rounded-xl shadow-sm flex items-center justify-between">
                                <span class="font-semibold text-slate-700">Bhabinkamtibmas</span>
                                <a href="tel:081234567892" class="text-blue-600 font-bold hover:underline">0812-3456-7892</a>
                            </div>
                            <div class="bg-white p-4 rounded-xl shadow-sm flex items-center justify-between">
                                <span class="font-semibold text-slate-700">Pemadam Kec.</span>
                                <a href="tel:113" class="text-red-600 font-bold hover:underline">113</a>
                            </div>
                            <div class="bg-white p-4 rounded-xl shadow-sm flex items-center justify-between">
                                <span class="font-semibold text-slate-700">PLN (Gangguan)</span>
                                <a href="tel:123" class="text-yellow-600 font-bold hover:underline">123</a>
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>
        </div>
    </section>

</x-public-layout>
