<x-admin-layout>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Kelola Surat Online</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar permohonan surat dari warga yang masuk ke sistem.</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-4 mb-6">
        <form action="{{ route('admin.layanan.surat.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="flex-1 w-full">
                <label for="search" class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Cari Pemohon / NIK</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           class="block w-full pl-10 pr-3 py-2 border border-slate-200 dark:border-slate-600 rounded-lg text-sm bg-slate-50 dark:bg-slate-900/50 text-slate-900 dark:text-slate-100 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ketik nama atau NIK...">
                </div>
            </div>
            
            <div class="w-full sm:w-48">
                <label for="status" class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Status</label>
                <select name="status" id="status" class="block w-full py-2 px-3 border border-slate-200 dark:border-slate-600 rounded-lg text-sm bg-slate-50 dark:bg-slate-900/50 text-slate-900 dark:text-slate-100 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    @foreach(\App\Enums\StatusSurat::cases() as $st)
                        @if($st->value !== 'draft')
                            <option value="{{ $st->value }}" {{ request('status') === $st->value ? 'selected' : '' }}>{{ $st->label() }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition-colors">
                    Terapkan Filter
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
                        <th class="px-6 py-4">Pemohon</th>
                        <th class="px-6 py-4">Jenis Surat</th>
                        <th class="px-6 py-4">Tanggal Pengajuan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($surats as $surat)
                    @php
                        $statusColors = [
                            'diajukan'            => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                            'diverifikasi'        => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400',
                            'diproses'            => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                            'menunggu_persetujuan'=> 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                            'selesai'             => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                            'ditolak'             => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                            'revisi'              => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                        ];
                    @endphp
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-900/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900 dark:text-white">{{ $surat->nama_pemohon }}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ $surat->nik_pemohon }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-700 dark:text-slate-200">{{ $surat->jenis_surat->label() }}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ $surat->nomor_surat ?? 'Belum ada nomor' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            {{ $surat->tanggal_pengajuan?->format('d M Y H:i') ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusColors[$surat->status->value] ?? 'bg-slate-100 text-slate-700' }}">
                                {{ $surat->status->label() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.layanan.surat.show', $surat->id) }}" class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                Proses / Cek
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            Tidak ada data surat yang sesuai filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200 dark:border-slate-700">
            {{ $surats->links('pagination::tailwind') }}
        </div>
    </div>
</x-admin-layout>
