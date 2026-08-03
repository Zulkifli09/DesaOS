<x-admin-layout>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Kelola Pengaduan</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar laporan dan aspirasi masyarakat.</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-4 mb-6">
        <form action="{{ route('admin.layanan.pengaduan.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="flex-1 w-full">
                <label for="search" class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Cari Laporan / Pelapor</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           class="block w-full pl-10 pr-3 py-2 border border-slate-200 dark:border-slate-600 rounded-lg text-sm bg-slate-50 dark:bg-slate-900/50 text-slate-900 dark:text-slate-100 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ketik kata kunci...">
                </div>
            </div>
            
            <div class="w-full sm:w-40">
                <label for="kategori" class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Kategori</label>
                <select name="kategori" id="kategori" class="block w-full py-2 px-3 border border-slate-200 dark:border-slate-600 rounded-lg text-sm bg-slate-50 dark:bg-slate-900/50 text-slate-900 dark:text-slate-100 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua</option>
                    @foreach(\App\Enums\PengaduanKategori::cases() as $kat)
                        <option value="{{ $kat->value }}" {{ request('kategori') === $kat->value ? 'selected' : '' }}>{{ $kat->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full sm:w-40">
                <label for="status" class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Status</label>
                <select name="status" id="status" class="block w-full py-2 px-3 border border-slate-200 dark:border-slate-600 rounded-lg text-sm bg-slate-50 dark:bg-slate-900/50 text-slate-900 dark:text-slate-100 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua</option>
                    @foreach(\App\Enums\PengaduanStatus::cases() as $st)
                        <option value="{{ $st->value }}" {{ request('status') === $st->value ? 'selected' : '' }}>{{ $st->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition-colors">
                    Terapkan
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 dark:text-slate-400 font-medium border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-4">Pelapor</th>
                        <th class="px-6 py-4">Judul & Kategori</th>
                        <th class="px-6 py-4">Prioritas</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($pengaduans as $item)
                    @php
                        $statusColors = [
                            'menunggu' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                            'diproses' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                            'selesai'  => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                            'ditolak'  => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                        ];
                        $prioColors = [
                            'rendah'   => 'text-slate-500',
                            'menengah' => 'text-yellow-600',
                            'tinggi'   => 'text-red-500',
                            'darurat'  => 'text-rose-600 font-bold',
                        ];
                    @endphp
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/50 transition-colors">
                        <td class="px-6 py-4">
                            @if($item->is_anonim)
                            <div class="font-medium text-slate-900 dark:text-white flex items-center gap-1">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                Anonim
                            </div>
                            @else
                            <div class="font-medium text-slate-900 dark:text-white">{{ $item->user->name }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900 dark:text-white mb-0.5 line-clamp-1" title="{{ $item->judul }}">{{ $item->judul }}</div>
                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">{{ $item->kategori->label() }}</div>
                        </td>
                        <td class="px-6 py-4 {{ $prioColors[$item->prioritas->value] ?? '' }}">
                            {{ $item->prioritas->label() }}
                        </td>
                        <td class="px-6 py-4 text-xs">
                            {{ $item->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusColors[$item->status->value] ?? 'bg-slate-100 text-slate-700' }}">
                                {{ $item->status->label() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.layanan.pengaduan.show', $item->id) }}" class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                Proses / Cek
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            Tidak ada data pengaduan yang sesuai filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200 dark:border-slate-700">
            {{ $pengaduans->links('pagination::tailwind') }}
        </div>
    </div>
</x-admin-layout>
