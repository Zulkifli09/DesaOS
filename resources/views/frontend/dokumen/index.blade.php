<x-public-layout>
    <x-slot name="title">Download Center - Dokumen Publik</x-slot>

    <!-- Header Section -->
    <section class="pt-32 pb-16 bg-white overflow-hidden relative border-b border-slate-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="md:w-1/2">
                    <span class="text-emerald-600 font-bold uppercase tracking-wider text-sm mb-2 block">Pusat Unduhan</span>
                    <h1 class="text-4xl md:text-5xl font-bold font-outfit text-slate-900 mb-6 leading-tight">Dokumen <span class="text-emerald-600">Publik</span></h1>
                    <p class="text-slate-600 text-lg mb-8 max-w-lg">Akses transparansi anggaran, peraturan desa, dan formulir pelayanan secara mudah dan terpusat.</p>
                    
                    <!-- Search Form -->
                    <form action="{{ route('dokumen.index') }}" method="GET" class="relative max-w-md">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama dokumen atau peraturan..." 
                               class="w-full bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 rounded-xl py-4 pl-12 pr-32 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all shadow-sm">
                        
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif

                        <button type="submit" class="absolute inset-y-2 right-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg px-6 font-semibold transition-colors">
                            Cari
                        </button>
                    </form>
                </div>
                
                <div class="md:w-1/2 relative hidden md:block">
                    <div class="absolute inset-0 bg-emerald-50 rounded-full blur-3xl transform scale-150"></div>
                    <img src="https://images.unsplash.com/photo-1568667256549-094345857637?q=80&w=1000&auto=format&fit=crop" alt="Dokumen Publik" class="relative z-10 rounded-2xl shadow-2xl -rotate-2 hover:rotate-0 transition-transform duration-500">
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Filter -->
    <section class="py-6 bg-slate-50 border-b border-slate-100 sticky top-16 z-40 shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4 overflow-x-auto pb-2 scrollbar-hide">
                <span class="text-sm font-bold text-slate-500 uppercase tracking-wider shrink-0 mr-2">Filter Kategori:</span>
                
                <a href="{{ route('dokumen.index') }}" class="shrink-0 px-5 py-2 rounded-full text-sm font-semibold transition-all border {{ !request('category') || request('category') == 'all' ? 'bg-slate-900 text-white border-slate-900 shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:border-slate-400 hover:bg-slate-100' }}">
                    Semua Dokumen
                </a>
                
                @foreach($categories as $cat)
                    <a href="{{ route('dokumen.index', ['category' => $cat]) }}" class="shrink-0 px-5 py-2 rounded-full text-sm font-semibold transition-all border {{ request('category') == $cat ? 'bg-emerald-600 text-white border-emerald-600 shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:border-emerald-400 hover:text-emerald-600' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Main List -->
    <section class="py-16 bg-slate-50 min-h-[50vh]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            
            @if(request('search') || request('category'))
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-slate-800">Menampilkan: 
                        @if(request('search')) Pencarian "<span class="text-emerald-600">{{ request('search') }}</span>" @endif
                        @if(request('category')) Kategori <span class="text-emerald-600">{{ request('category') }}</span> @endif
                    </h2>
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                @if($documents->count() > 0)
                    <ul class="divide-y divide-slate-100">
                        @foreach($documents as $doc)
                            @php
                                $ext = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION));
                                $iconColor = match($ext) {
                                    'pdf' => 'text-red-500 bg-red-50',
                                    'doc', 'docx' => 'text-blue-500 bg-blue-50',
                                    'xls', 'xlsx' => 'text-green-500 bg-green-50',
                                    default => 'text-slate-500 bg-slate-50'
                                };
                            @endphp
                            <li class="p-6 hover:bg-slate-50 transition-colors flex flex-col md:flex-row items-start md:items-center gap-6">
                                <div class="shrink-0 {{ $iconColor }} p-4 rounded-xl border border-slate-100">
                                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="flex-grow">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-500 border border-slate-200 rounded px-2 py-0.5">{{ $doc->category }}</span>
                                        <span class="text-[10px] font-bold uppercase tracking-widest {{ $iconColor }} rounded px-2 py-0.5">{{ $ext }}</span>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-900 leading-tight mb-2">{{ $doc->title }}</h3>
                                    <p class="text-sm text-slate-500 line-clamp-2">{{ strip_tags($doc->description) }}</p>
                                </div>
                                <div class="shrink-0 flex flex-col items-end gap-2 w-full md:w-auto mt-4 md:mt-0">
                                    <a href="{{ route('dokumen.download', $doc->id) }}" class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                        Unduh
                                    </a>
                                    <span class="text-xs font-medium text-slate-400">Diunduh: {{ $doc->downloads_count }}x</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-16">
                        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        <p class="text-slate-500 text-lg">Belum ada dokumen yang tersedia.</p>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $documents->links() }}
            </div>

        </div>
    </section>

</x-public-layout>
