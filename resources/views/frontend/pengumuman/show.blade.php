<x-public-layout>
    <x-slot name="title">{{ $announcement->title }} - Pengumuman</x-slot>

    <!-- Header Area -->
    <section class="pt-32 pb-10 bg-slate-50 border-b border-slate-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
            <!-- Breadcrumbs -->
            <nav class="flex text-sm text-slate-500 mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors">Beranda</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <a href="{{ route('pengumuman.index') }}" class="hover:text-emerald-600 transition-colors">Pengumuman</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="text-slate-400">Detail</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-slate-100 relative overflow-hidden">
                <!-- Status Badge -->
                <div class="absolute top-0 right-0 p-6">
                    @if($announcement->expired_at && $announcement->expired_at < now())
                        <span class="bg-slate-100 text-slate-500 font-bold px-3 py-1 rounded-full text-sm">Berlalu</span>
                    @else
                        <span class="bg-green-100 text-green-700 font-bold px-3 py-1 rounded-full text-sm flex items-center gap-1">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                            Aktif
                        </span>
                    @endif
                </div>

                <div class="mb-6 flex items-center gap-3">
                    <span class="text-xs font-bold px-3 py-1.5 rounded-lg uppercase tracking-wide
                        @if($announcement->type == 'darurat') bg-red-100 text-red-700
                        @elseif($announcement->type == 'kegiatan') bg-blue-100 text-blue-700
                        @else bg-emerald-100 text-emerald-700 @endif
                    ">
                        Pengumuman {{ ucfirst($announcement->type) }}
                    </span>
                    <span class="text-slate-500 text-sm flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Dipublikasikan {{ $announcement->created_at->translatedFormat('d F Y H:i') }}
                    </span>
                </div>

                <h1 class="text-3xl md:text-4xl font-bold font-outfit text-slate-900 leading-tight mb-8">
                    {{ $announcement->title }}
                </h1>

                <!-- Content Area -->
                <div class="prose prose-lg prose-slate max-w-none prose-headings:font-outfit prose-a:text-emerald-600 border-t border-slate-100 pt-8">
                    {!! $announcement->content !!}
                </div>

                <!-- Attachment Area -->
                @if($announcement->attachment)
                    <div class="mt-10 p-6 bg-slate-50 rounded-2xl border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">Lampiran Dokumen Resmi</h4>
                                <p class="text-sm text-slate-500">Silakan unduh dokumen untuk informasi lebih rinci.</p>
                            </div>
                        </div>
                        <a href="{{ Storage::url($announcement->attachment) }}" target="_blank" download class="shrink-0 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl flex items-center gap-2 transition-all shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            Unduh File
                        </a>
                    </div>
                @endif
                
            </div>
        </div>
    </section>

    <!-- Related Announcements -->
    @if($relatedAnnouncements->count() > 0)
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
            <h3 class="text-2xl font-bold font-outfit text-slate-900 mb-8 border-b pb-4">
                Pengumuman Lainnya
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($relatedAnnouncements as $related)
                    <a href="{{ route('pengumuman.show', $related->slug) }}" class="block p-5 bg-slate-50 rounded-2xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50 transition-colors group">
                        <div class="text-xs text-slate-500 mb-2">{{ $related->created_at->format('d M Y') }}</div>
                        <h4 class="font-bold text-slate-800 group-hover:text-emerald-700 leading-snug line-clamp-2">{{ $related->title }}</h4>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</x-public-layout>
