<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Statistik Kependudukan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-indigo-50 border-l-4 border-indigo-400 p-4 mb-6 rounded-r shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-indigo-700">
                            Halaman ini menggunakan pendekatan <strong>Input Agregat</strong>. Anda cukup memasukkan angka akhir (total) dari data kependudukan desa. Data ini akan otomatis dirender menjadi grafik interaktif di halaman Portal Publik.
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.statistics.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- 1. Angka Utama (Wilayah & KK) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">1. Angka Utama Wilayah</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total Penduduk</label>
                                <input type="number" min="0" name="total_population" value="{{ old('total_population', $statistic->total_population) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total Kepala Keluarga (KK)</label>
                                <input type="number" min="0" name="total_family" value="{{ old('total_family', $statistic->total_family) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jumlah Dusun</label>
                                <input type="number" min="0" name="total_dusun" value="{{ old('total_dusun', $statistic->total_dusun) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jumlah RW</label>
                                <input type="number" min="0" name="total_rw" value="{{ old('total_rw', $statistic->total_rw) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jumlah RT</label>
                                <input type="number" min="0" name="total_rt" value="{{ old('total_rt', $statistic->total_rt) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- 2. Gender (Jenis Kelamin) -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">2. Jenis Kelamin</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Laki-laki</label>
                                    <input type="number" min="0" name="gender_data[laki_laki]" value="{{ old('gender_data.laki_laki', $statistic->gender_data['laki_laki'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Perempuan</label>
                                    <input type="number" min="0" name="gender_data[perempuan]" value="{{ old('gender_data.perempuan', $statistic->gender_data['perempuan'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Usia -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">3. Kelompok Usia</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">0 - 4 Tahun</label>
                                    <input type="number" min="0" name="age_data[0_4]" value="{{ old('age_data.0_4', $statistic->age_data['0_4'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">5 - 14 Tahun</label>
                                    <input type="number" min="0" name="age_data[5_14]" value="{{ old('age_data.5_14', $statistic->age_data['5_14'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">15 - 39 Tahun</label>
                                    <input type="number" min="0" name="age_data[15_39]" value="{{ old('age_data.15_39', $statistic->age_data['15_39'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">40 - 64 Tahun</label>
                                    <input type="number" min="0" name="age_data[40_64]" value="{{ old('age_data.40_64', $statistic->age_data['40_64'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">65+ Tahun (Lansia)</label>
                                    <input type="number" min="0" name="age_data[65_plus]" value="{{ old('age_data.65_plus', $statistic->age_data['65_plus'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Pendidikan & Agama -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">4. Pendidikan Terakhir</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Belum / Tidak Sekolah</label>
                                    <input type="number" min="0" name="education_data[belum_sekolah]" value="{{ old('education_data.belum_sekolah', $statistic->education_data['belum_sekolah'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tamat TK</label>
                                    <input type="number" min="0" name="education_data[tk]" value="{{ old('education_data.tk', $statistic->education_data['tk'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">SD / Sederajat</label>
                                    <input type="number" min="0" name="education_data[sd]" value="{{ old('education_data.sd', $statistic->education_data['sd'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">SMP / Sederajat</label>
                                    <input type="number" min="0" name="education_data[smp]" value="{{ old('education_data.smp', $statistic->education_data['smp'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">SMA / Sederajat</label>
                                    <input type="number" min="0" name="education_data[sma]" value="{{ old('education_data.sma', $statistic->education_data['sma'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Diploma (D1-D3)</label>
                                    <input type="number" min="0" name="education_data[d1_d3]" value="{{ old('education_data.d1_d3', $statistic->education_data['d1_d3'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Sarjana (S1)</label>
                                    <input type="number" min="0" name="education_data[s1]" value="{{ old('education_data.s1', $statistic->education_data['s1'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Pascasarjana (S2/S3)</label>
                                    <input type="number" min="0" name="education_data[s2_s3]" value="{{ old('education_data.s2_s3', $statistic->education_data['s2_s3'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">5. Agama</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Islam</label>
                                    <input type="number" min="0" name="religion_data[islam]" value="{{ old('religion_data.islam', $statistic->religion_data['islam'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kristen</label>
                                    <input type="number" min="0" name="religion_data[kristen]" value="{{ old('religion_data.kristen', $statistic->religion_data['kristen'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Katolik</label>
                                    <input type="number" min="0" name="religion_data[katolik]" value="{{ old('religion_data.katolik', $statistic->religion_data['katolik'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Hindu</label>
                                    <input type="number" min="0" name="religion_data[hindu]" value="{{ old('religion_data.hindu', $statistic->religion_data['hindu'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Buddha</label>
                                    <input type="number" min="0" name="religion_data[buddha]" value="{{ old('religion_data.buddha', $statistic->religion_data['buddha'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Konghucu</label>
                                    <input type="number" min="0" name="religion_data[konghucu]" value="{{ old('religion_data.konghucu', $statistic->religion_data['konghucu'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. Pekerjaan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">6. Pekerjaan Utama</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Belum / Tidak Bekerja</label>
                                <input type="number" min="0" name="job_data[belum_bekerja]" value="{{ old('job_data.belum_bekerja', $statistic->job_data['belum_bekerja'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pelajar / Mahasiswa</label>
                                <input type="number" min="0" name="job_data[pelajar_mahasiswa]" value="{{ old('job_data.pelajar_mahasiswa', $statistic->job_data['pelajar_mahasiswa'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">PNS</label>
                                <input type="number" min="0" name="job_data[pns]" value="{{ old('job_data.pns', $statistic->job_data['pns'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">TNI / POLRI</label>
                                <input type="number" min="0" name="job_data[tni_polri]" value="{{ old('job_data.tni_polri', $statistic->job_data['tni_polri'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Petani / Pekebun</label>
                                <input type="number" min="0" name="job_data[petani]" value="{{ old('job_data.petani', $statistic->job_data['petani'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nelayan</label>
                                <input type="number" min="0" name="job_data[nelayan]" value="{{ old('job_data.nelayan', $statistic->job_data['nelayan'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Wiraswasta / Dagang</label>
                                <input type="number" min="0" name="job_data[wiraswasta]" value="{{ old('job_data.wiraswasta', $statistic->job_data['wiraswasta'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Karyawan Swasta</label>
                                <input type="number" min="0" name="job_data[karyawan_swasta]" value="{{ old('job_data.karyawan_swasta', $statistic->job_data['karyawan_swasta'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Buruh</label>
                                <input type="number" min="0" name="job_data[buruh]" value="{{ old('job_data.buruh', $statistic->job_data['buruh'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pensiunan</label>
                                <input type="number" min="0" name="job_data[pensiunan]" value="{{ old('job_data.pensiunan', $statistic->job_data['pensiunan'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Lainnya</label>
                                <input type="number" min="0" name="job_data[lainnya]" value="{{ old('job_data.lainnya', $statistic->job_data['lainnya'] ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-indigo-600 py-3 px-8 border border-transparent rounded-md shadow-lg text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full sm:w-auto">
                        Simpan Pembaruan Data
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
