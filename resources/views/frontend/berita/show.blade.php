<x-public-layout>
    <x-slot name="title">{{ $article->title }}</x-slot>

    <!-- Article Header -->
    <section class="pt-32 pb-10 bg-slate-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
            <!-- Breadcrumbs -->
            <nav class="flex text-sm text-slate-500 mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors">Beranda</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <a href="{{ route('berita.index') }}" class="hover:text-emerald-600 transition-colors">Berita</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="text-slate-400">{{ Str::limit($article->title, 30) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="mb-6">
                <a href="{{ route('berita.index', ['kategori' => $article->category->slug]) }}" class="inline-block bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-4 hover:bg-emerald-200 transition-colors">
                    {{ $article->category->name }}
                </a>
                <h1 class="text-3xl md:text-5xl font-bold font-outfit text-slate-900 leading-tight mb-6">
                    {{ $article->title }}
                </h1>
                
                <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500 border-y border-slate-200 py-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold uppercase">
                            {{ substr($article->user->name, 0, 1) }}
                        </div>
                        <span class="font-medium text-slate-700">{{ $article->user->name }}</span>
                    </div>
                    <span class="hidden sm:inline text-slate-300">•</span>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        {{ $article->published_at->translatedFormat('l, d F Y H:i') }}
                    </div>
                    <span class="hidden sm:inline text-slate-300">•</span>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ $article->estimated_reading_time }} mnt baca
                    </div>
                    <span class="hidden sm:inline text-slate-300">•</span>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        {{ number_format($article->views) }} kali dibaca
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cover Image -->
    @if($article->image)
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="rounded-3xl overflow-hidden shadow-lg aspect-video bg-slate-100">
            <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
        </div>
    </section>
    @endif

    <!-- Content Area -->
    <section class="pb-20 bg-slate-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
            <div class="flex flex-col lg:flex-row gap-12">
                
                <!-- Main Article -->
                <div class="w-full lg:w-2/3">
                    <article class="prose prose-lg prose-slate max-w-none prose-headings:font-outfit prose-a:text-emerald-600 bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-slate-100 mb-8">
                        {!! $article->content !!}
                    </article>

                    <!-- Tags & Social Share -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-6 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm mb-12">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-sm font-bold text-slate-400 mr-2">Tags:</span>
                            @if($article->tags)
                                @foreach($article->tags as $tag)
                                    <a href="#" class="bg-slate-100 text-slate-600 hover:bg-emerald-100 hover:text-emerald-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors">#{{ $tag }}</a>
                                @endforeach
                            @else
                                <span class="text-sm text-slate-400 italic">Tidak ada tag</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-bold text-slate-400">Bagikan:</span>
                            <!-- WA Share -->
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . request()->url()) }}" target="_blank" class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:scale-110 transition-transform shadow-md">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            </a>
                            <!-- Twitter Share -->
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->url()) }}" target="_blank" class="w-10 h-10 rounded-full bg-[#1DA1F2] text-white flex items-center justify-center hover:scale-110 transition-transform shadow-md">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                            </a>
                            <!-- FB Share -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="w-10 h-10 rounded-full bg-[#1877F2] text-white flex items-center justify-center hover:scale-110 transition-transform shadow-md">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Related News -->
                    @if($relatedNews->count() > 0)
                        <div>
                            <h3 class="text-2xl font-bold font-outfit text-slate-900 mb-6 flex items-center gap-2">
                                Berita Terkait
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                @foreach($relatedNews as $related)
                                    <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md border border-slate-100 transition-all group">
                                        <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                                            @if($related->image)
                                                <img src="{{ Storage::url($related->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <h4 class="font-bold text-slate-900 text-sm leading-snug group-hover:text-emerald-600 transition-colors line-clamp-2 mb-2">
                                                <a href="{{ route('berita.show', $related->slug) }}">{{ $related->title }}</a>
                                            </h4>
                                            <span class="text-xs text-slate-500">{{ $related->published_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Right Sidebar (Popular News & Categories) -->
                <aside class="w-full lg:w-1/3 space-y-8">
                    <!-- Kategori Widget -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-24">
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
