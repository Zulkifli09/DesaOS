<x-public-layout>
    <x-slot name="title">Profil Desa</x-slot>

    <!-- Page Header (Hero) -->
    <section class="relative pt-32 pb-20 bg-slate-900 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1596422846543-74c6fc1e360f?q=80&w=2070&auto=format&fit=crop" alt="Balai Desa" class="w-full h-full object-cover opacity-30 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-slate-900/40"></div>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center" x-data="{ shown: false }" x-intersect.once="shown = true">
            <div class="max-w-3xl mx-auto transition-all duration-1000 translate-y-8 opacity-0" :class="shown && '!translate-y-0 !opacity-100'">
                <h1 class="text-4xl md:text-5xl font-bold font-outfit text-white mb-4">Profil <span class="text-emerald-500">Desa</span></h1>
                <p class="text-slate-300 text-lg">Mengenal lebih dekat sejarah, visi, misi, dan susunan pemerintahan Desa Kami yang transparan dan melayani.</p>
            </div>
        </div>
    </section>

    <!-- Reading Layout: Sidebar & Content -->
    <section class="py-16 bg-slate-50 relative" x-data="{ activeSection: 'sambutan' }">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-12 items-start">
                
                <!-- Sticky Sidebar Navigation -->
                <div class="hidden lg:block lg:w-1/4 sticky top-24">
                    <nav class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Daftar Isi</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="#sambutan" @click.prevent="document.getElementById('sambutan').scrollIntoView({behavior: 'smooth'}); activeSection = 'sambutan'"
                                   class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                                   :class="activeSection === 'sambutan' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'">
                                    Sambutan Kepala Desa
                                </a>
                            </li>
                            <li>
                                <a href="#sejarah" @click.prevent="document.getElementById('sejarah').scrollIntoView({behavior: 'smooth'}); activeSection = 'sejarah'"
                                   class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                                   :class="activeSection === 'sejarah' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'">
                                    Sejarah & Perkembangan
                                </a>
                            </li>
                            <li>
                                <a href="#visimisi" @click.prevent="document.getElementById('visimisi').scrollIntoView({behavior: 'smooth'}); activeSection = 'visimisi'"
                                   class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                                   :class="activeSection === 'visimisi' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'">
                                    Visi dan Misi
                                </a>
                            </li>
                            <li>
                                <a href="#struktur" @click.prevent="document.getElementById('struktur').scrollIntoView({behavior: 'smooth'}); activeSection = 'struktur'"
                                   class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                                   :class="activeSection === 'struktur' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'">
                                    Struktur Organisasi
                                </a>
                            </li>
                            <li>
                                <a href="#demografi" @click.prevent="document.getElementById('demografi').scrollIntoView({behavior: 'smooth'}); activeSection = 'demografi'"
                                   class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                                   :class="activeSection === 'demografi' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'">
                                    Demografi & Wilayah
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="w-full lg:w-3/4 space-y-20">
                    
                    <!-- Sambutan Kepala Desa -->
                    <div id="sambutan" class="scroll-mt-32" x-intersect="activeSection = 'sambutan'">
                        <div class="bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-slate-200 relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-8 opacity-5">
                                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                            </div>
                            
                            <div class="flex flex-col md:flex-row gap-8 items-center md:items-start relative z-10">
                                <div class="w-40 h-40 flex-shrink-0 rounded-full overflow-hidden border-4 border-emerald-50 shadow-lg">
                                    <!-- Placeholder Kades -->
                                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=200&auto=format&fit=crop" alt="Kepala Desa" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold font-outfit text-slate-900 mb-2">Sambutan Kepala Desa</h2>
                                    <p class="text-sm font-semibold text-emerald-600 mb-6 uppercase tracking-wider">Bpk. Ahmad Subarjo, S.Sos.</p>
                                    
                                    <div class="prose prose-slate max-w-none text-slate-600">
                                        <p class="text-lg leading-relaxed italic mb-4 text-slate-700">"Puji syukur kehadirat Tuhan Yang Maha Esa atas rahmat-Nya, DesaOS kini hadir sebagai wujud nyata transformasi digital desa. Kami berkomitmen memberikan pelayanan transparan, cepat, dan modern tanpa melupakan nilai gotong royong warisan leluhur."</p>
                                        <p>Melalui portal ini, kami berharap masyarakat dapat dengan mudah mengakses informasi kependudukan, transparansi anggaran, serta layanan administrasi dari rumah. Mari bersama-sama membangun desa ini menuju masa depan yang lebih baik dan bermartabat.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sejarah Desa & Timeline -->
                    <div id="sejarah" class="scroll-mt-32" x-intersect="activeSection = 'sejarah'">
                        <div class="mb-10">
                            <h2 class="text-3xl font-bold font-outfit text-slate-900 mb-4 border-b pb-4">Sejarah & Perkembangan Desa</h2>
                            <div class="prose prose-slate max-w-none text-slate-600 mb-10">
                                <p>Desa ini berdiri sejak abad ke-19, berawal dari pemukiman kecil kaum petani dan nelayan di tepi muara. Nama desa ini diambil dari pohon besar yang dulunya menjadi tempat berkumpul dan bermusyawarah para tetua desa. Seiring berjalannya waktu, desa berkembang pesat berkat kesuburan tanah dan potensi pariwisata yang mulai terbuka pada tahun 1990-an.</p>
                            </div>
                        </div>

                        <!-- Modern Timeline Component -->
                        <div class="relative border-l-2 border-slate-200 ml-4 md:ml-6 pl-8 space-y-12">
                            <div class="relative">
                                <div class="absolute -left-[41px] top-1 w-5 h-5 rounded-full bg-emerald-500 border-4 border-white shadow-sm"></div>
                                <span class="text-sm font-bold text-emerald-600 mb-1 block">1895</span>
                                <h4 class="text-lg font-bold text-slate-900 mb-2">Awal Mula Pemukiman</h4>
                                <p class="text-slate-600 text-sm">Pembentukan kelompok pemukim pertama yang dipimpin oleh Ki Buyut Mangun, membuka lahan pertanian dan menetapkan batas-batas wilayah tradisional.</p>
                            </div>
                            <div class="relative">
                                <div class="absolute -left-[41px] top-1 w-5 h-5 rounded-full bg-emerald-500 border-4 border-white shadow-sm"></div>
                                <span class="text-sm font-bold text-emerald-600 mb-1 block">1945 - 1950</span>
                                <h4 class="text-lg font-bold text-slate-900 mb-2">Masa Kemerdekaan</h4>
                                <p class="text-slate-600 text-sm">Penyatuan wilayah-wilayah dusun ke dalam satu pemerintahan desa definitif sebagai bagian dari NKRI.</p>
                            </div>
                            <div class="relative">
                                <div class="absolute -left-[41px] top-1 w-5 h-5 rounded-full bg-emerald-500 border-4 border-white shadow-sm"></div>
                                <span class="text-sm font-bold text-emerald-600 mb-1 block">1998</span>
                                <h4 class="text-lg font-bold text-slate-900 mb-2">Pembangunan Infrastruktur Masif</h4>
                                <p class="text-slate-600 text-sm">Masuknya jaringan listrik, aspal jalan poros utama, dan pendirian sekolah dasar pertama yang mengubah wajah desa.</p>
                            </div>
                            <div class="relative">
                                <div class="absolute -left-[41px] top-1 w-5 h-5 rounded-full bg-emerald-500 border-4 border-white shadow-sm animate-pulse"></div>
                                <span class="text-sm font-bold text-emerald-600 mb-1 block">Sekarang</span>
                                <h4 class="text-lg font-bold text-slate-900 mb-2">Desa Digital Modern (DesaOS)</h4>
                                <p class="text-slate-600 text-sm">Penerapan teknologi pelayanan publik satu pintu dan keterbukaan informasi bagi seluruh lapisan masyarakat.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Visi dan Misi -->
                    <div id="visimisi" class="scroll-mt-32" x-intersect="activeSection = 'visimisi'">
                        <h2 class="text-3xl font-bold font-outfit text-slate-900 mb-8 border-b pb-4">Visi dan Misi</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Visi -->
                            <div class="bg-gradient-to-br from-emerald-600 to-teal-800 rounded-3xl p-8 text-white shadow-lg">
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-6">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </div>
                                <h3 class="text-2xl font-bold font-outfit mb-4">Visi Kami</h3>
                                <p class="text-emerald-50 text-lg leading-relaxed font-medium">
                                    "Terwujudnya Desa yang Mandiri, Sejahtera, Transparan, dan Berbudaya berbasis Teknologi Informasi pada tahun 2030."
                                </p>
                            </div>
                            
                            <!-- Misi -->
                            <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
                                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center mb-6">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                </div>
                                <h3 class="text-2xl font-bold font-outfit text-slate-900 mb-4">Misi Kami</h3>
                                <ul class="space-y-4">
                                    <li class="flex items-start gap-3 text-slate-600">
                                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        <span>Meningkatkan kualitas pelayanan administrasi publik yang cepat dan tepat.</span>
                                    </li>
                                    <li class="flex items-start gap-3 text-slate-600">
                                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        <span>Memberdayakan ekonomi kerakyatan melalui BUMDes dan pembinaan UMKM.</span>
                                    </li>
                                    <li class="flex items-start gap-3 text-slate-600">
                                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        <span>Mewujudkan infrastruktur jalan dan fasilitas umum yang merata.</span>
                                    </li>
                                    <li class="flex items-start gap-3 text-slate-600">
                                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        <span>Menjaga kelestarian adat, budaya, dan lingkungan hidup.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Struktur Organisasi -->
                    <div id="struktur" class="scroll-mt-32" x-intersect="activeSection = 'struktur'">
                        <h2 class="text-3xl font-bold font-outfit text-slate-900 mb-8 border-b pb-4">Struktur Organisasi Pemerintahan</h2>
                        
                        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm text-center">
                            <!-- Placeholder Hierarchy -->
                            <div class="inline-block p-4 border border-emerald-200 bg-emerald-50 rounded-xl mb-8">
                                <h4 class="font-bold text-slate-900">Kepala Desa</h4>
                                <p class="text-sm text-emerald-600">Ahmad Subarjo</p>
                            </div>
                            
                            <div class="h-8 w-px bg-slate-300 mx-auto -mt-8 mb-4"></div>
                            <div class="w-2/3 h-px bg-slate-300 mx-auto"></div>
                            
                            <div class="flex justify-between w-2/3 mx-auto mt-4 gap-4">
                                <div class="w-1/2">
                                    <div class="p-3 border border-slate-200 rounded-lg">
                                        <h4 class="font-bold text-sm text-slate-900">Sekretaris Desa</h4>
                                        <p class="text-xs text-slate-500">Budi Santoso</p>
                                    </div>
                                </div>
                                <div class="w-1/2">
                                    <div class="p-3 border border-slate-200 rounded-lg">
                                        <h4 class="font-bold text-sm text-slate-900">Ketua BPD</h4>
                                        <p class="text-xs text-slate-500">H. Ridwan</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-8 text-slate-500 text-sm border border-dashed border-slate-300 rounded-xl p-8 bg-slate-50">
                                <em>Bagan struktur organisasi lengkap sedang dalam penyesuaian data terbaru.</em>
                            </div>
                        </div>
                    </div>

                    <!-- Demografi -->
                    <div id="demografi" class="scroll-mt-32" x-intersect="activeSection = 'demografi'">
                        <h2 class="text-3xl font-bold font-outfit text-slate-900 mb-8 border-b pb-4">Demografi & Wilayah Administrasi</h2>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-center">
                                <div class="text-3xl font-bold text-emerald-600 mb-1">4</div>
                                <div class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Dusun</div>
                            </div>
                            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-center">
                                <div class="text-3xl font-bold text-emerald-600 mb-1">12</div>
                                <div class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Rukun Warga</div>
                            </div>
                            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-center">
                                <div class="text-3xl font-bold text-emerald-600 mb-1">48</div>
                                <div class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Rukun Tetangga</div>
                            </div>
                            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm text-center">
                                <div class="text-3xl font-bold text-emerald-600 mb-1">1,250</div>
                                <div class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Hektar Luas</div>
                            </div>
                        </div>
                        
                        <div class="bg-slate-900 rounded-3xl p-8 text-white">
                            <h3 class="text-xl font-bold mb-6 font-outfit">Ringkasan Penduduk</h3>
                            <div class="space-y-6">
                                <div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span>Laki-laki (51%)</span>
                                        <span class="font-bold">2.550 Jiwa</span>
                                    </div>
                                    <div class="w-full bg-slate-700 rounded-full h-2">
                                        <div class="bg-emerald-500 h-2 rounded-full" style="width: 51%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span>Perempuan (49%)</span>
                                        <span class="font-bold">2.450 Jiwa</span>
                                    </div>
                                    <div class="w-full bg-slate-700 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: 49%"></div>
                                    </div>
                                </div>
                                <div class="pt-4 mt-4 border-t border-slate-700 flex justify-between items-center">
                                    <span class="text-slate-400">Total Kepala Keluarga (KK)</span>
                                    <span class="text-2xl font-bold text-white">1.250</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
