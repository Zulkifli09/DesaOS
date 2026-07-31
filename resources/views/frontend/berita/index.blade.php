<x-public-layout>
    <x-slot name="title">Portal Berita</x-slot>

    <!-- Header Section -->
    <section class="pt-32 pb-16 bg-slate-900 overflow-hidden relative">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-emerald-900/40 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-bold font-outfit text-white mb-4">Portal <span class="text-emerald-500">Berita</span></h1>
                <p class="text-slate-300 text-lg">Ikuti kabar, pengumuman, dan artikel terbaru langsung dari sumber terpercaya desa kami.</p>
            </div>
            
            <!-- Search Bar -->
            <div class="mt-10 max-w-2xl relative">
                <form action="{{ route('berita.index') }}" method="GET" class="relative flex items-center">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..." 
                           class="w-full bg-white/10 border border-white/20 text-white placeholder-slate-400 rounded-full py-4 pl-6 pr-16 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white/20 transition-all backdrop-blur-sm">
                    <button type="submit" class="absolute right-2 p-3 bg-emerald-600 hover:bg-emerald-500 text-white rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16 bg-slate-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-12">
                
                <!-- Left Column (Main Feed) -->
                <div class="w-full lg:w-2/3 xl:w-3/4">
                    
                    @if(request()->has('search') || request()->has('kategori'))
                        <div class="mb-8 flex items-center gap-2">
                            <span class="text-slate-500">Menampilkan hasil untuk:</span>
                            @if(request('search'))
                                <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-sm font-semibold">Pencarian: "{{ request('search') }}"</span>
                            @endif
                            @if(request('kategori'))
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">Kategori: {{ request('kategori') }}</span>
                            @endif
                            <a href="{{ route('berita.index') }}" class="text-sm text-red-500 hover:underline ml-2">Reset Filter</a>
                        </div>
                    @endif

                    <!-- Featured News (Hanya tampil jika tidak sedang search) -->
                    @if(!request()->has('search') && !request()->has('kategori') && $featuredNews->count() > 0)
                        <div class="mb-12">
                            <h2 class="text-2xl font-bold font-outfit text-slate-900 mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                                Berita Utama
                            </h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($featuredNews as $featured)
                                    <article class="group relative rounded-2xl overflow-hidden shadow-md aspect-[4/3] md:aspect-auto md:h-96">
                                        @if($featured->image)
                                            <img src="{{ Storage::url($featured->image) }}" alt="{{ $featured->title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                        @else
                                            <div class="absolute inset-0 w-full h-full bg-slate-800 flex items-center justify-center text-slate-500">No Image</div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div>
                                        <div class="absolute bottom-0 left-0 p-6 w-full">
                                            <div class="flex items-center gap-3 mb-3">
                                                <span class="bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">{{ $featured->category->name }}</span>
                                                <span class="text-slate-300 text-xs flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> {{ $featured->estimated_reading_time }} mnt baca</span>
                                            </div>
                                            <h3 class="text-2xl font-bold text-white mb-2 leading-tight group-hover:text-emerald-400 transition-colors">
                                                <a href="{{ route('berita.show', $featured->slug) }}" class="before:absolute before:inset-0">{{ $featured->title }}</a>
                                            </h3>
                                            <div class="flex items-center gap-2 text-sm text-slate-400 mt-4">
                                                <span>Oleh {{ $featured->user->name }}</span>
                                                <span>•</span>
                                                <span>{{ $featured->published_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Latest News Grid -->
                    <div>
                        <h2 class="text-2xl font-bold font-outfit text-slate-900 mb-6 border-b pb-4">
                            {{ (request()->has('search') || request()->has('kategori')) ? 'Hasil Temuan' : 'Berita Terbaru' }}
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse($articles as $article)
                                <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 flex flex-col h-full group">
                                    <div class="relative aspect-video overflow-hidden bg-slate-100">
                                        @if($article->image)
                                            <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-400">No Image</div>
                                        @endif
                                        <div class="absolute top-3 left-3 flex gap-2">
                                            <span class="bg-white/90 backdrop-blur-sm text-slate-800 text-xs font-bold px-2 py-1 rounded">{{ $article->category->name }}</span>
                                        </div>
                                    </div>
                                    <div class="p-5 flex flex-col flex-grow">
                                        <h3 class="text-lg font-bold text-slate-900 mb-2 leading-snug group-hover:text-emerald-600 transition-colors line-clamp-2">
                                            <a href="{{ route('berita.show', $article->slug) }}">{{ $article->title }}</a>
                                        </h3>
                                        <p class="text-slate-600 text-sm mb-4 line-clamp-3 flex-grow">
                                            {{ Str::limit(strip_tags($article->content), 100) }}
                                        </p>
                                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-100 text-xs text-slate-500">
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                {{ $article->published_at->format('d M Y') }}
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                                {{ number_format($article->views) }}
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-slate-300">
                                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    <p class="text-slate-500 text-lg">Belum ada artikel berita yang dipublikasikan.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12">
                            {{ $articles->links() }}
                        </div>
                    </div>

                </div>

                <!-- Right Column (Sidebar) -->
                <aside class="w-full lg:w-1/3 xl:w-1/4 space-y-8">
                    
                    <!-- Kategori Widget -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                        <h3 class="font-bold text-lg text-slate-900 mb-4 border-l-4 border-emerald-500 pl-3">Kategori</h3>
                        <ul class="space-y-3">
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('berita.index', ['kategori' => $category->slug]) }}" 
                                       class="flex items-center justify-between text-slate-600 hover:text-emerald-600 group transition-colors">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                            {{ $category->name }}
                                        </span>
                                        <span class="bg-slate-100 text-slate-500 text-xs py-1 px-2 rounded-full group-hover:bg-emerald-100 group-hover:text-emerald-600 transition-colors">{{ $category->articles_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Popular News Widget -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                        <h3 class="font-bold text-lg text-slate-900 mb-4 border-l-4 border-blue-500 pl-3">Terpopuler</h3>
                        <div class="space-y-6">
                            @foreach($popularNews as $index => $popular)
                                <div class="flex gap-4 group">
                                    <div class="font-bold text-2xl text-slate-200 group-hover:text-blue-200 transition-colors">
                                        #{{ $index + 1 }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm leading-snug group-hover:text-blue-600 transition-colors line-clamp-2 mb-1">
                                            <a href="{{ route('berita.show', $popular->slug) }}">{{ $popular->title }}</a>
                                        </h4>
                                        <div class="flex items-center gap-2 text-xs text-slate-500">
                                            <span class="text-blue-600 font-medium">{{ $popular->category->name }}</span>
                                            <span>•</span>
                                            <span>{{ number_format($popular->views) }} views</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </aside>
                
            </div>
        </div>
    </section>

</x-public-layout>
