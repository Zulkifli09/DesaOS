<x-public-layout>
    <x-slot name="title">Direktori UMKM</x-slot>

    <!-- Header -->
    <section class="pt-32 pb-16 bg-white overflow-hidden relative border-b border-slate-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="md:w-1/2">
                    <span class="text-blue-600 font-bold uppercase tracking-wider text-sm mb-2 block">Dukung Produk Lokal</span>
                    <h1 class="text-4xl md:text-5xl font-bold font-outfit text-slate-900 mb-6 leading-tight">Direktori <span class="text-blue-600">UMKM Desa</span></h1>
                    <p class="text-slate-600 text-lg mb-8 max-w-lg">Temukan produk unggulan, kuliner lezat, hingga kerajinan tangan hasil karya terbaik dari masyarakat desa kami.</p>
                    
                    <!-- Search Form -->
                    <form action="{{ route('umkm.index') }}" method="GET" class="relative max-w-md">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama toko, produk, atau layanan..." 
                               class="w-full bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 rounded-xl py-4 pl-12 pr-32 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all shadow-sm">
                        
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        
                        <!-- preserve category filter -->
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif

                        <button type="submit" class="absolute inset-y-2 right-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-6 font-semibold transition-colors">
                            Cari
                        </button>
                    </form>
                </div>
                
                <div class="md:w-1/2 relative hidden md:block">
                    <div class="absolute inset-0 bg-blue-50 rounded-full blur-3xl transform scale-150"></div>
                    <img src="https://images.unsplash.com/photo-1556740758-90de374c12ad?q=80&w=1000&auto=format&fit=crop" alt="UMKM" class="relative z-10 rounded-2xl shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500">
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Filter -->
    <section class="py-8 bg-slate-50 border-b border-slate-100 sticky top-16 z-40 shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4 overflow-x-auto pb-2 scrollbar-hide">
                <span class="text-sm font-bold text-slate-500 uppercase tracking-wider shrink-0 mr-2">Kategori:</span>
                
                <a href="{{ route('umkm.index') }}" class="shrink-0 px-5 py-2 rounded-full text-sm font-semibold transition-all border {{ !request('category') ? 'bg-slate-900 text-white border-slate-900 shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:border-slate-400 hover:bg-slate-100' }}">
                    Semua UMKM
                </a>
                
                @foreach($categories as $cat)
                    <a href="{{ route('umkm.index', ['category' => $cat]) }}" class="shrink-0 px-5 py-2 rounded-full text-sm font-semibold transition-all border {{ request('category') == $cat ? 'bg-blue-600 text-white border-blue-600 shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-400 hover:text-blue-600' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Section (Only show if no search/filter) -->
    @if(isset($featuredUmkms) && $featuredUmkms->count() > 0)
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 mb-8">
                <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                <h2 class="text-2xl font-bold font-outfit text-slate-900">Rekomendasi Pilihan</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredUmkms as $featured)
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl border border-amber-100 p-1">
                        <a href="{{ route('umkm.show', $featured->slug) }}" class="block bg-white rounded-xl p-5 hover:shadow-lg transition-all duration-300 h-full flex flex-col">
                            <div class="flex items-start gap-4 mb-4">
                                <img src="{{ Storage::url($featured->logo) }}" alt="Logo" class="w-16 h-16 rounded-full object-cover shadow-sm border border-slate-100 shrink-0">
                                <div>
                                    <span class="inline-block px-2 py-1 bg-amber-100 text-amber-800 text-[10px] font-bold uppercase tracking-wider rounded mb-1">
                                        {{ $featured->category }}
                                    </span>
                                    <h3 class="text-lg font-bold text-slate-900 leading-tight">{{ $featured->name }}</h3>
                                </div>
                            </div>
                            
                            <p class="text-slate-500 text-sm mb-4 line-clamp-2 flex-grow">{{ strip_tags($featured->description) }}</p>
                            
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-sm">
                                <span class="text-slate-500 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <span class="truncate max-w-[120px]">{{ $featured->location }}</span>
                                </span>
                                <span class="text-blue-600 font-semibold group-hover:text-blue-700">Kunjungi Toko &rarr;</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Main List -->
    <section class="py-16 bg-slate-50 min-h-[50vh]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(request('search') || request('category'))
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-slate-800">Hasil Pencarian: 
                        @if(request('search')) "<span class="text-blue-600">{{ request('search') }}</span>" @endif
                        @if(request('category')) Kategori <span class="text-blue-600">{{ request('category') }}</span> @endif
                    </h2>
                </div>
            @else
                <div class="mb-8">
                    <h2 class="text-2xl font-bold font-outfit text-slate-900">Jelajahi Semua UMKM</h2>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($umkms as $umkm)
                    <a href="{{ route('umkm.show', $umkm->slug) }}" class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full transform hover:-translate-y-1">
                        <!-- Cover Area with blurred logo bg -->
                        <div class="relative h-32 overflow-hidden bg-slate-800">
                            <img src="{{ Storage::url($umkm->logo) }}" class="w-full h-full object-cover opacity-40 blur-sm transform scale-110 group-hover:scale-125 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-white via-white/80 to-transparent"></div>
                            
                            <!-- Category Badge -->
                            <div class="absolute top-3 right-3 z-10">
                                <span class="bg-white/90 backdrop-blur px-2.5 py-1 text-[10px] font-bold text-slate-700 rounded-lg shadow-sm border border-slate-200 uppercase tracking-wider">
                                    {{ $umkm->category }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Logo Avatar overlapping cover -->
                        <div class="px-5 relative -mt-10 mb-3">
                            <div class="w-20 h-20 rounded-xl border-4 border-white shadow-md overflow-hidden bg-white relative z-10">
                                <img src="{{ Storage::url($umkm->logo) }}" alt="{{ $umkm->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                        </div>
                        
                        <div class="px-5 pb-5 flex flex-col flex-grow">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <h3 class="text-lg font-bold text-slate-900 leading-tight group-hover:text-blue-600 transition-colors">{{ $umkm->name }}</h3>
                                @if($umkm->is_featured)
                                    <svg class="w-5 h-5 text-yellow-500 shrink-0" fill="currentColor" viewBox="0 0 20 20" title="Featured"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endif
                            </div>
                            
                            <p class="text-slate-500 text-sm line-clamp-2 mb-4 flex-grow">
                                {{ strip_tags($umkm->description) }}
                            </p>
                            
                            <div class="border-t border-slate-100 pt-4 mt-auto">
                                <div class="flex items-center gap-2 text-xs text-slate-500 mb-2">
                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <span class="truncate">{{ $umkm->location }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-16 text-center">
                        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        <p class="text-slate-500 text-lg">Belum ada data UMKM yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $umkms->links() }}
            </div>

        </div>
    </section>

</x-public-layout>
