<x-public-layout>
    <x-slot name="title">Pengumuman Desa</x-slot>

    <!-- Header Section -->
    <section class="pt-32 pb-16 bg-slate-900 overflow-hidden relative">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-emerald-900/40 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-bold font-outfit text-white mb-4">Papan <span class="text-emerald-500">Pengumuman</span></h1>
                <p class="text-slate-300 text-lg">Informasi resmi, agenda kegiatan, dan imbauan penting langsung dari Pemerintah Desa.</p>
            </div>
            
            <!-- Search & Filter -->
            <div class="mt-10 max-w-4xl relative">
                <form action="{{ route('pengumuman.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-grow">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul pengumuman..." 
                               class="w-full bg-white/10 border border-white/20 text-white placeholder-slate-400 rounded-xl py-3 pl-5 pr-12 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white/20 transition-all backdrop-blur-sm">
                    </div>
                    <div class="w-full sm:w-48 relative">
                        <select name="type" onchange="this.form.submit()" class="w-full bg-white/10 border border-white/20 text-white rounded-xl py-3 pl-5 pr-10 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white/20 transition-all backdrop-blur-sm appearance-none">
                            <option value="" class="text-slate-900" {{ request('type') == '' ? 'selected' : '' }}>Semua Kategori</option>
                            <option value="umum" class="text-slate-900" {{ request('type') == 'umum' ? 'selected' : '' }}>Umum</option>
                            <option value="kegiatan" class="text-slate-900" {{ request('type') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                            <option value="darurat" class="text-slate-900" {{ request('type') == 'darurat' ? 'selected' : '' }}>Darurat</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl py-3 px-6 font-semibold transition-colors shrink-0">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16 bg-slate-50 min-h-[50vh]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            
            <div class="space-y-6">
                @forelse($announcements as $announcement)
                    <a href="{{ route('pengumuman.show', $announcement->slug) }}" class="block bg-white rounded-2xl p-6 shadow-sm hover:shadow-md border border-slate-100 transition-all group relative overflow-hidden">
                        
                        <!-- Accent Line for Type -->
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 
                            @if($announcement->type == 'darurat') bg-red-500
                            @elseif($announcement->type == 'kegiatan') bg-blue-500
                            @else bg-emerald-500 @endif
                        "></div>

                        <div class="flex flex-col md:flex-row gap-6 md:items-center justify-between pl-4">
                            <div class="flex-grow">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-xs font-bold px-2 py-1 rounded-md uppercase tracking-wide
                                        @if($announcement->type == 'darurat') bg-red-100 text-red-700
                                        @elseif($announcement->type == 'kegiatan') bg-blue-100 text-blue-700
                                        @else bg-slate-100 text-slate-700 @endif
                                    ">
                                        {{ $announcement->type }}
                                    </span>
                                    <span class="text-sm text-slate-500 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        {{ $announcement->created_at->format('d M Y') }}
                                    </span>
                                </div>
                                
                                <h3 class="text-xl font-bold text-slate-900 group-hover:text-emerald-600 transition-colors">
                                    {{ $announcement->title }}
                                </h3>
                                
                                <p class="text-slate-600 mt-2 line-clamp-2 text-sm">
                                    {{ Str::limit(strip_tags($announcement->content), 120) }}
                                </p>
                            </div>
                            
                            <div class="shrink-0 flex items-center justify-between md:flex-col md:items-end gap-3 border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-6">
                                @if($announcement->attachment)
                                    <div class="flex items-center gap-1 text-sm font-semibold text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-full">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                        File Terlampir
                                    </div>
                                @else
                                    <div></div> <!-- spacer -->
                                @endif
                                
                                <span class="text-emerald-600 text-sm font-bold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                    Baca Selengkapnya
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="py-16 text-center bg-white rounded-2xl border border-dashed border-slate-300">
                        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        <p class="text-slate-500 text-lg">Tidak ada pengumuman yang ditemukan.</p>
                        @if(request('search') || request('type'))
                            <a href="{{ route('pengumuman.index') }}" class="text-emerald-600 hover:underline mt-2 inline-block">Reset Filter Pencarian</a>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $announcements->links() }}
            </div>

        </div>
    </section>

</x-public-layout>
