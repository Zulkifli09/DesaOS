<x-public-layout>
    <x-slot name="title">{{ $potential->name }} - Potensi Desa</x-slot>

    <!-- Hero Section -->
    <section class="pt-32 pb-24 bg-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ Storage::url($potential->cover_image) }}" alt="Cover" class="w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div>
        </div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <a href="{{ route('potensi.index') }}" class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 mb-6 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali ke Direktori
            </a>
            
            <div class="max-w-4xl">
                <span class="text-xs font-bold px-3 py-1 bg-blue-600 text-white rounded-full uppercase tracking-widest shadow-sm mb-4 inline-block">
                    {{ $potential->category }}
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold font-outfit text-white mb-6 leading-tight">
                    {{ $potential->name }}
                </h1>
                
                <div class="flex flex-wrap items-center gap-6 text-slate-300 text-sm">
                    @if($potential->location)
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            {{ $potential->location }}
                        </div>
                    @endif
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Dipublikasikan {{ $potential->created_at->format('d M Y') }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16 bg-slate-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-12 relative items-start">
                
                <!-- Left Content: Description & Gallery -->
                <div class="lg:w-2/3">
                    <!-- Description -->
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100 mb-10 prose prose-slate max-w-none prose-headings:font-outfit prose-headings:font-bold prose-a:text-blue-600 hover:prose-a:text-blue-500">
                        {!! nl2br(e($potential->description)) !!}
                    </div>

                    <!-- Mini Gallery Lightbox -->
                    @if($potential->gallery_images && count($potential->gallery_images) > 0)
                        <div class="mb-10" x-data="{ 
                            lightboxOpen: false, 
                            currentImage: '', 
                            currentIndex: 0,
                            images: [
                                @foreach($potential->gallery_images as $img)
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
                            <h3 class="text-2xl font-bold font-outfit text-slate-900 mb-6">Galeri Foto</h3>
                            
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($potential->gallery_images as $index => $img)
                                    <div class="aspect-square rounded-xl overflow-hidden cursor-pointer group bg-slate-200" @click="openLightbox({{ $index }})">
                                        <img src="{{ Storage::url($img) }}" alt="Gallery {{ $index+1 }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <svg class="w-8 h-8 text-white drop-shadow" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" /></svg>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

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
                                
                                <div class="w-full max-w-5xl p-4 flex justify-center items-center" @click.away="closeLightbox()">
                                    <img :src="currentImage" class="max-h-[85vh] max-w-full object-contain shadow-2xl rounded" alt="Zoomed">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Sidebar: Contact & CTA -->
                <div class="lg:w-1/3 lg:sticky lg:top-28 space-y-6">
                    
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="text-lg font-bold font-outfit text-slate-900 mb-4 pb-4 border-b border-slate-100">Informasi Kontak</h3>
                        
                        <div class="space-y-4">
                            @if($potential->contact_name)
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Pengelola / Pemilik</p>
                                    <p class="text-slate-900 font-medium">{{ $potential->contact_name }}</p>
                                </div>
                            </div>
                            @endif

                            @if($potential->contact_phone)
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Telepon / WhatsApp</p>
                                    <p class="text-slate-900 font-medium">+{{ $potential->contact_phone }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- CTA WhatsApp -->
                        @if($potential->contact_phone)
                            <div class="mt-8">
                                @php
                                    // Clean phone number
                                    $phone = preg_replace('/[^0-9]/', '', $potential->contact_phone);
                                    // Ensure it starts with country code (assuming 62 for ID)
                                    if(str_starts_with($phone, '0')) {
                                        $phone = '62' . substr($phone, 1);
                                    }
                                    
                                    $waMessage = "Halo {$potential->contact_name}, saya melihat informasi terkait *{$potential->name}* di Website Desa. Boleh minta informasi lebih lanjut?";
                                    $waLink = "https://wa.me/{$phone}?text=" . urlencode($waMessage);
                                @endphp
                                <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-2 w-full bg-[#25D366] hover:bg-[#128C7E] text-white font-bold py-3 px-4 rounded-xl transition-colors shadow-sm shadow-[#25D366]/30 hover:shadow-lg hover:shadow-[#25D366]/40 transform hover:-translate-y-0.5">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.418-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.029 18.88c-1.161 0-2.305-.292-3.318-.844l-3.677.964.984-3.595c-.607-1.052-.927-2.246-.926-3.468.001-5.824 4.74-10.563 10.564-10.563 5.826 0 10.564 4.741 10.564 10.564 0 5.824-4.74 10.564-10.564 10.564z"/></svg>
                                    Hubungi Sekarang
                                </a>
                            </div>
                        @else
                            <div class="mt-8 text-center text-sm text-slate-500 bg-slate-50 p-4 rounded-lg border border-slate-100">
                                Nomor kontak tidak tersedia.
                            </div>
                        @endif
                    </div>
                    
                    <div class="bg-blue-600 rounded-2xl p-6 text-white text-center shadow-lg relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white/10 blur-2xl"></div>
                        <h4 class="font-bold font-outfit mb-2 text-lg">Punya Potensi Serupa?</h4>
                        <p class="text-sm text-blue-100 mb-6">Daftarkan usaha atau potensi Anda ke direktori desa untuk menjangkau lebih banyak orang.</p>
                        <a href="#" class="inline-block bg-white text-blue-600 text-sm font-bold py-2 px-6 rounded-full hover:bg-blue-50 transition-colors">
                            Daftarkan Sekarang
                        </a>
                    </div>
                </div>
                
            </div>
            
            <!-- Related Potentials -->
            @if($relatedPotentials->count() > 0)
                <div class="mt-20 border-t border-slate-200 pt-16">
                    <h2 class="text-3xl font-bold font-outfit text-slate-900 mb-8">{{ $potential->category }} Lainnya</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedPotentials as $related)
                            <a href="{{ route('potensi.show', $related->slug) }}" class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full transform hover:-translate-y-1">
                                <div class="relative h-48 overflow-hidden bg-slate-200">
                                    <img src="{{ Storage::url($related->cover_image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                </div>
                                <div class="p-5 flex flex-col flex-grow">
                                    <h3 class="text-lg font-bold text-slate-900 mb-2 leading-tight group-hover:text-blue-600 transition-colors">{{ $related->name }}</h3>
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
