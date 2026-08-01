<x-pelayanan-layout title="Notifikasi">
    <div class="p-6 max-w-3xl mx-auto">
        
        {{-- Header --}}
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="font-outfit font-bold text-2xl text-slate-900">Notifikasi</h1>
                <p class="text-slate-500 mt-1 text-sm">Pemberitahuan aktivitas layanan dan informasi dari desa.</p>
            </div>
            @if($notifikasis->count())
            <form action="{{ route('pelayanan.notifikasi.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 font-medium bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl transition-colors">
                    Tandai Semua Dibaca
                </button>
            </form>
            @endif
        </div>

        {{-- List --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            @if($notifikasis->count())
                <div class="divide-y divide-slate-100">
                    @foreach($notifikasis as $notif)
                    <div class="p-5 flex gap-4 hover:bg-slate-50 transition-colors {{ !$notif->read_at ? 'bg-blue-50/30' : '' }}">
                        
                        {{-- Icon --}}
                        <div class="w-12 h-12 rounded-full shrink-0 flex items-center justify-center
                            {{ $notif->tipe === 'info' ? 'bg-blue-100 text-blue-600' : '' }}
                            {{ $notif->tipe === 'success' ? 'bg-green-100 text-green-600' : '' }}
                            {{ $notif->tipe === 'warning' ? 'bg-yellow-100 text-yellow-600' : '' }}
                            {{ $notif->tipe === 'danger' ? 'bg-red-100 text-red-600' : '' }}">
                            @if($notif->tipe === 'success')
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @elseif($notif->tipe === 'danger')
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @elseif($notif->tipe === 'warning')
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <h3 class="font-semibold text-sm {{ !$notif->read_at ? 'text-slate-900' : 'text-slate-700' }}">
                                    {{ $notif->judul }}
                                </h3>
                                <time class="text-[10px] text-slate-400 whitespace-nowrap shrink-0">{{ $notif->created_at->diffForHumans() }}</time>
                            </div>
                            <p class="text-sm text-slate-500 mb-2">{{ $notif->pesan }}</p>
                            
                            <div class="flex items-center gap-3">
                                @if($notif->action_url)
                                <a href="{{ $notif->action_url }}" class="text-xs font-semibold text-blue-600 hover:underline">
                                    Lihat Detail →
                                </a>
                                @endif
                                
                                @if(!$notif->read_at)
                                <form action="{{ route('pelayanan.notifikasi.mark-read', $notif->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-[10px] text-slate-400 hover:text-slate-600 font-medium bg-slate-100 hover:bg-slate-200 px-2 py-0.5 rounded transition-colors">
                                        Tandai Dibaca
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>

                        {{-- Unread Dot --}}
                        @if(!$notif->read_at)
                        <div class="shrink-0 flex items-center">
                            <span class="w-2.5 h-2.5 bg-blue-500 rounded-full"></span>
                        </div>
                        @endif

                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="p-4 border-t border-slate-100">
                    {{ $notifikasis->links('pagination::tailwind') }}
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-slate-900 mb-1">Belum ada notifikasi</h3>
                    <p class="text-sm text-slate-500">Anda tidak memiliki notifikasi baru saat ini.</p>
                </div>
            @endif
        </div>
    </div>
</x-pelayanan-layout>
