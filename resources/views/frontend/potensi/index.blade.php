<x-public-layout>
    <x-slot name="title">Potensi Desa</x-slot>

    <!-- Header -->
    <section class="pt-32 pb-16 bg-slate-900 overflow-hidden relative">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-blue-900/40 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-bold font-outfit text-white mb-4">Direktori <span class="text-blue-500">Potensi Desa</span></h1>
                <p class="text-slate-300 text-lg">Jelajahi kekayaan alam, pariwisata, hingga produk unggulan UMKM yang menjadi kebanggaan desa kami.</p>
            </div>
            
            <!-- Filter & Search -->
            <div class="mt-10 max-w-2xl mx-auto">
                <form action="{{ route('potensi.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-grow">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari potensi, nama produk, wisata..." 
                               class="w-full bg-white/10 border border-white/20 text-white placeholder-slate-400 rounded-xl py-3 pl-5 pr-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white/20 transition-all backdrop-blur-sm">
                        <!-- preserve category filter if exists -->
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white rounded-xl py-3 px-6 font-semibold transition-colors shrink-0">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Categories -->
            <div class="mt-8 flex flex-wrap justify-center gap-2">
                <a href="{{ route('potensi.index') }}" class="px-4 py-1.5 rounded-full text-xs font-semibold transition-colors border {{ !request('category') ? 'bg-blue-600 text-white border-blue-600' : 'bg-transparent text-slate-300 border-slate-600 hover:border-blue-500 hover:text-white' }}">Semua</a>
                @foreach($categories as $cat)
                    <a href="{{ route('potensi.index', ['category' => $cat]) }}" class="px-4 py-1.5 rounded-full text-xs font-semibold transition-colors border {{ request('category') == $cat ? 'bg-blue-600 text-white border-blue-600' : 'bg-transparent text-slate-300 border-slate-600 hover:border-blue-500 hover:text-white' }}">{{ $cat }}</a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16 bg-slate-50 min-h-[50vh]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($potentials as $index => $potential)
                    <a href="{{ route('potensi.show', $potential->slug) }}" class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full transform hover:-translate-y-1">
                        <div class="relative h-48 overflow-hidden bg-slate-200">
                            <img src="{{ Storage::url($potential->cover_image) }}" alt="{{ $potential->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            
                            <div class="absolute top-3 right-3">
                                <span class="bg-white/90 backdrop-blur-sm px-3 py-1 text-[10px] font-bold text-blue-700 rounded-full uppercase tracking-wider shadow-sm">
                                    {{ $potential->category }}
                                </span>
                            </div>

                            @if($potential->gallery_images)
                                <div class="absolute bottom-3 left-3 bg-black/50 backdrop-blur-sm text-white px-2 py-1 rounded text-xs flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    {{ count($potential->gallery_images) }} Foto
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-slate-900 mb-2 leading-tight group-hover:text-blue-600 transition-colors">{{ $potential->name }}</h3>
                            <p class="text-slate-500 text-sm line-clamp-3 mb-4 flex-grow">
                                {{ strip_tags($potential->description) }}
                            </p>
                            
                            <div class="border-t border-slate-100 pt-4 mt-auto">
                                @if($potential->location)
                                    <div class="flex items-start gap-2 text-xs text-slate-500 mb-2">
                                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        <span class="truncate">{{ $potential->location }}</span>
                                    </div>
                                @endif
                                
                                <span class="text-blue-600 font-semibold text-sm group-hover:text-blue-700 flex items-center gap-1 mt-2">
                                    Lihat Detail
                                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-16 text-center">
                        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        <p class="text-slate-500 text-lg">Belum ada data potensi desa yang dipublikasikan.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $potentials->links() }}
            </div>

        </div>
    </section>

</x-public-layout>
