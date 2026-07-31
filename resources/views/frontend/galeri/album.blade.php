<x-public-layout>
    <x-slot name="title">Album: {{ $album->name }} - Galeri Desa</x-slot>

    <!-- Header -->
    <section class="pt-32 pb-16 bg-slate-900 overflow-hidden relative">
        <div class="absolute inset-0 z-0">
            @if($album->cover_image)
                <img src="{{ Storage::url($album->cover_image) }}" alt="Cover" class="w-full h-full object-cover opacity-30">
            @else
                <div class="absolute inset-0 bg-emerald-900/40 mix-blend-multiply"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/80 to-transparent"></div>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            
            <a href="{{ route('galeri.index') }}" class="inline-flex items-center gap-2 text-emerald-400 hover:text-emerald-300 mb-6 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali ke Indeks Galeri
            </a>
            
            <div class="max-w-3xl mx-auto">
                <span class="text-xs font-bold px-3 py-1 bg-white/10 text-white rounded-full uppercase tracking-widest backdrop-blur-sm border border-white/20 mb-4 inline-block">
                    Album Galeri
                </span>
                <h1 class="text-4xl md:text-5xl font-bold font-outfit text-white mb-4">{{ $album->name }}</h1>
                <p class="text-slate-300 text-lg">{{ $album->description ?? 'Dokumentasi kegiatan dan potensi desa.' }}</p>
                <div class="mt-6 text-emerald-500 font-semibold">
                    {{ $galleries->total() }} Media Terlampir
                </div>
            </div>
            
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16 bg-slate-50 min-h-[50vh]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Masonry Grid with Alpine JS Lightbox -->
            <div x-data="{ 
                lightboxOpen: false, 
                currentMedia: null, 
                currentIndex: 0,
                mediaList: [],
                openLightbox(index) {
                    this.currentIndex = index;
                    this.currentMedia = this.mediaList[index];
                    this.lightboxOpen = true;
                    document.body.style.overflow = 'hidden';
                },
                closeLightbox() {
                    this.lightboxOpen = false;
                    document.body.style.overflow = 'auto';
                    let iframe = document.getElementById('lightbox-video');
                    if(iframe) {
                        let src = iframe.src;
                        iframe.src = src;
                    }
                },
                next() {
                    this.currentIndex = (this.currentIndex + 1) % this.mediaList.length;
                    this.currentMedia = this.mediaList[this.currentIndex];
                },
                prev() {
                    this.currentIndex = (this.currentIndex - 1 + this.mediaList.length) % this.mediaList.length;
                    this.currentMedia = this.mediaList[this.currentIndex];
                }
            }" 
            x-init="
                mediaList = [
                    @foreach($galleries as $gallery)
                    {
                        type: '{{ $gallery->type }}',
                        url: '{{ $gallery->type === 'image' ? Storage::url($gallery->media_path) : $gallery->media_path }}',
                        title: '{{ addslashes($gallery->title) }}',
                        description: '{{ addslashes($gallery->description) }}',
                        downloadable: {{ $gallery->is_downloadable ? 'true' : 'false' }},
                        album: '{{ addslashes($album->name) }}'
                    }{{ !$loop->last ? ',' : '' }}
                    @endforeach
                ];
            ">
                
                @if($galleries->count() > 0)
                    <div class="columns-1 sm:columns-2 lg:columns-3 gap-6 space-y-6">
                        @foreach($galleries as $index => $gallery)
                            <div class="break-inside-avoid relative group rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 bg-white border border-slate-100 cursor-pointer" @click="openLightbox({{ $index }})">
                                
                                @if($gallery->type === 'image')
                                    <img src="{{ Storage::url($gallery->media_path) }}" alt="{{ $gallery->title }}" class="w-full h-auto object-cover" loading="lazy">
                                @else
                                    <div class="w-full aspect-video bg-slate-900 flex items-center justify-center relative">
                                        @if($gallery->type === 'drone')
                                            <div class="absolute inset-0 bg-gradient-to-tr from-emerald-900/40 to-transparent"></div>
                                        @endif
                                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                            <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </div>
                                @endif

                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider bg-white/20 text-white backdrop-blur-md">
                                            {{ $gallery->type == 'drone' ? 'Panorama Udara' : ucfirst($gallery->type) }}
                                        </span>
                                    </div>
                                    <h3 class="text-white font-bold text-lg leading-tight translate-y-4 group-hover:translate-y-0 transition-transform duration-300">{{ $gallery->title }}</h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-16 text-center">
                        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <p class="text-slate-500 text-lg">Belum ada media di album ini.</p>
                    </div>
                @endif

                <!-- Lightbox Modal -->
                <div x-show="lightboxOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95 backdrop-blur-sm" x-cloak
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    
                    <button @click="closeLightbox()" class="absolute top-6 right-6 text-white/50 hover:text-white transition-colors z-[110]">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <button @click.stop="prev()" class="absolute left-4 md:left-10 top-1/2 -translate-y-1/2 text-white/50 hover:text-white transition-colors p-2 z-[110]" x-show="mediaList.length > 1">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button @click.stop="next()" class="absolute right-4 md:right-10 top-1/2 -translate-y-1/2 text-white/50 hover:text-white transition-colors p-2 z-[110]" x-show="mediaList.length > 1">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>

                    <div class="relative w-full h-full flex flex-col items-center justify-center p-4 md:p-12" @click.away="closeLightbox()">
                        
                        <div class="w-full max-w-6xl max-h-[75vh] flex items-center justify-center relative">
                            <template x-if="currentMedia && currentMedia.type === 'image'">
                                <img :src="currentMedia.url" class="max-w-full max-h-[75vh] object-contain rounded-sm shadow-2xl" alt="Gallery Media">
                            </template>
                            
                            <template x-if="currentMedia && (currentMedia.type === 'video' || currentMedia.type === 'drone')">
                                <div class="w-full max-w-4xl aspect-video rounded-xl overflow-hidden shadow-2xl bg-black">
                                    <iframe id="lightbox-video" :src="currentMedia.url" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            </template>
                        </div>

                        <div class="absolute bottom-0 left-0 w-full p-6 md:p-10 bg-gradient-to-t from-black/90 to-transparent text-center md:text-left flex flex-col md:flex-row md:items-end justify-between gap-4">
                            <div class="max-w-3xl">
                                <span class="text-emerald-400 text-sm font-bold tracking-wider uppercase mb-1 block" x-text="currentMedia?.album || 'Galeri Umum'"></span>
                                <h3 class="text-2xl md:text-3xl font-bold text-white mb-2" x-text="currentMedia?.title"></h3>
                                <p class="text-slate-300 text-sm md:text-base line-clamp-2 md:line-clamp-none" x-text="currentMedia?.description"></p>
                            </div>
                            
                            <template x-if="currentMedia && currentMedia.downloadable && currentMedia.type === 'image'">
                                <a :href="currentMedia.url" download class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-md text-white px-5 py-2.5 rounded-xl font-medium transition-colors shrink-0 mx-auto md:mx-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Unduh Original
                                </a>
                            </template>
                        </div>
                    </div>
                </div>

            </div> <!-- end Alpine x-data -->

            <!-- Pagination -->
            <div class="mt-12">
                {{ $galleries->links() }}
            </div>

        </div>
    </section>
</x-public-layout>
