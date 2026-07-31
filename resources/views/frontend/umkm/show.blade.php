<x-public-layout>
    <x-slot name="title">{{ $umkm->name }} - UMKM Desa</x-slot>

    <!-- Header Section -->
    <section class="pt-32 pb-16 bg-slate-50 relative overflow-hidden border-b border-slate-200">
        <div class="absolute inset-0 z-0">
            <!-- decorative background -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-100/50 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-amber-100/50 blur-3xl"></div>
        </div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <a href="{{ route('umkm.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 mb-8 transition-colors text-sm font-semibold">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali ke Direktori UMKM
            </a>
            
            <div class="flex flex-col md:flex-row gap-8 items-start">
                <!-- Logo -->
                <div class="w-32 h-32 md:w-48 md:h-48 rounded-2xl border-4 border-white shadow-xl overflow-hidden bg-white shrink-0">
                    <img src="{{ Storage::url($umkm->logo) }}" alt="Logo {{ $umkm->name }}" class="w-full h-full object-cover">
                </div>
                
                <!-- Info -->
                <div class="flex-grow pt-2">
                    <div class="flex flex-wrap items-center gap-3 mb-3">
                        <span class="text-xs font-bold px-3 py-1 bg-white border border-slate-200 text-slate-700 rounded-lg uppercase tracking-widest shadow-sm">
                            {{ $umkm->category }}
                        </span>
                        @if($umkm->is_featured)
                            <span class="text-xs font-bold px-3 py-1 bg-yellow-100 text-yellow-800 rounded-lg uppercase tracking-widest shadow-sm flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                Pilihan Desa
                            </span>
                        @endif
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold font-outfit text-slate-900 mb-4 leading-tight">
                        {{ $umkm->name }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center gap-6 text-slate-600 text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            {{ $umkm->location }}
                        </div>
                        
                        @if($umkm->operational_hours)
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $umkm->operational_hours }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-12 relative items-start">
                
                <!-- Left Content: Description & Gallery -->
                <div class="lg:w-2/3">
                    <!-- Description -->
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100 mb-10">
                        <h3 class="text-2xl font-bold font-outfit text-slate-900 mb-6">Tentang Usaha & Produk</h3>
                        <div class="prose prose-slate max-w-none prose-headings:font-outfit prose-headings:font-bold prose-a:text-blue-600 hover:prose-a:text-blue-500 text-slate-600 leading-relaxed">
                            {!! nl2br(e($umkm->description)) !!}
                        </div>
                    </div>

                    <!-- Mini Gallery Lightbox -->
                    @if($umkm->gallery_images && count($umkm->gallery_images) > 0)
                        <div class="mb-10" x-data="{ 
                            lightboxOpen: false, 
                            currentImage: '', 
                            currentIndex: 0,
                            images: [
                                @foreach($umkm->gallery_images as $img)
                                '{{ Storage::url($img) }}'{{ !$loop->last ? ',' : '' }}
                                @endforeach
                            ],
                            openLightbox(index) {
                                this.currentIndex = index;
                                this.currentImage = this.images[index];
                                this.lightboxOpen = true;
                                document.body.style.overflow = 'hidden';
                            },
                            closeLightbox() {
                                this.lightboxOpen = false;
                                document.body.style.overflow = 'auto';
                            }
                        }">
                            <h3 class="text-2xl font-bold font-outfit text-slate-900 mb-6">Katalog Produk</h3>
                            
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($umkm->gallery_images as $index => $img)
                                    <div class="aspect-square rounded-xl overflow-hidden cursor-pointer group bg-slate-100 border border-slate-200 shadow-sm hover:shadow-md transition-shadow" @click="openLightbox({{ $index }})">
                                        <img src="{{ Storage::url($img) }}" alt="Produk {{ $index+1 }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                                            <span class="bg-blue-600 text-white p-2 rounded-full shadow-lg transform scale-0 group-hover:scale-100 transition-transform">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" /></svg>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Lightbox Modal -->
                            <div x-show="lightboxOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/95 backdrop-blur-sm" x-cloak
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0">
                                
                                <button @click="closeLightbox()" class="absolute top-6 right-6 text-white/50 hover:text-white transition-colors z-[110] bg-slate-800/50 p-2 rounded-full">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                                
                                <div class="w-full max-w-5xl p-4 flex justify-center items-center" @click.away="closeLightbox()">
                                    <img :src="currentImage" class="max-h-[85vh] max-w-full object-contain shadow-2xl rounded-lg" alt="Zoomed">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Sidebar: Contact & Actions -->
                <div class="lg:w-1/3 lg:sticky lg:top-28 space-y-6">
                    
                    <div class="bg-white rounded-2xl p-6 shadow-xl shadow-slate-200/50 border border-slate-100 text-center">
                        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-6">Pesan Sekarang</h3>
                        
                        <!-- CTA WhatsApp -->
                        @php
                            $phone = preg_replace('/[^0-9]/', '', $umkm->whatsapp);
                            if(str_starts_with($phone, '0')) {
                                $phone = '62' . substr($phone, 1);
                            }
                            $waMessage = "Halo *{$umkm->name}*, saya melihat lapak Anda di Direktori DesaOS. Boleh minta katalog atau info lebih lanjut?";
                            $waLink = "https://wa.me/{$phone}?text=" . urlencode($waMessage);
                        @endphp
                        
                        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" class="flex flex-col items-center justify-center w-full bg-[#25D366] hover:bg-[#128C7E] text-white font-bold py-4 px-4 rounded-xl transition-all shadow-lg shadow-[#25D366]/30 hover:shadow-xl hover:shadow-[#25D366]/40 transform hover:-translate-y-1 mb-4 group">
                            <div class="flex items-center gap-2 mb-1">
                                <svg class="w-6 h-6 transform group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.418-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.029 18.88c-1.161 0-2.305-.292-3.318-.844l-3.677.964.984-3.595c-.607-1.052-.927-2.246-.926-3.468.001-5.824 4.74-10.563 10.564-10.563 5.826 0 10.564 4.741 10.564 10.564 0 5.824-4.74 10.564-10.564 10.564z"/></svg>
                                Pesan via WhatsApp
                            </div>
                            <span class="text-xs font-medium text-white/80">+{{ $umkm->whatsapp }}</span>
                        </a>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <!-- Maps URL -->
                            @if($umkm->maps_url)
                                <a href="{{ $umkm->maps_url }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-2 w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3 px-4 rounded-xl transition-colors text-sm">
                                    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    Buka Peta
                                </a>
                            @else
                                <div class="flex items-center justify-center gap-2 w-full bg-slate-50 text-slate-400 font-semibold py-3 px-4 rounded-xl text-sm border border-slate-100 cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    Peta (-)
                                </div>
                            @endif

                            <!-- Instagram -->
                            @if($umkm->instagram)
                                @php
                                    $igUrl = str_starts_with($umkm->instagram, 'http') ? $umkm->instagram : 'https://instagram.com/' . str_replace('@', '', $umkm->instagram);
                                @endphp
                                <a href="{{ $igUrl }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-2 w-full bg-pink-50 hover:bg-pink-100 text-pink-600 font-semibold py-3 px-4 rounded-xl transition-colors text-sm">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                    Instagram
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                
            </div>
            
            <!-- Related UMKM -->
            @if($relatedUmkms->count() > 0)
                <div class="mt-20 border-t border-slate-200 pt-16">
                    <h2 class="text-3xl font-bold font-outfit text-slate-900 mb-8">UMKM {{ $umkm->category }} Lainnya</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedUmkms as $related)
                            <a href="{{ route('umkm.show', $related->slug) }}" class="group flex flex-col bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                                <div class="relative h-32 overflow-hidden bg-slate-800 shrink-0">
                                    <img src="{{ Storage::url($related->logo) }}" class="w-full h-full object-cover opacity-40 blur-sm">
                                </div>
                                <div class="px-5 relative -mt-10 mb-3 shrink-0">
                                    <div class="w-16 h-16 rounded-xl border-4 border-white shadow-sm overflow-hidden bg-white relative z-10">
                                        <img src="{{ Storage::url($related->logo) }}" class="w-full h-full object-cover">
                                    </div>
                                </div>
                                <div class="px-5 pb-5 flex flex-col flex-grow">
                                    <h3 class="text-lg font-bold text-slate-900 mb-1 group-hover:text-blue-600 transition-colors">{{ $related->name }}</h3>
                                    <p class="text-slate-500 text-sm line-clamp-2">
                                        {{ strip_tags($related->description) }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>
</x-public-layout>
