<x-public-layout>
    <x-slot name="title">Statistik Desa</x-slot>

    <!-- Header & Main Counters -->
    <section class="pt-32 pb-24 bg-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-blue-900/20 mix-blend-multiply"></div>
            <!-- Grid pattern -->
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.05) 1px, transparent 0); background-size: 32px 32px;"></div>
        </div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-blue-400 font-bold uppercase tracking-wider text-sm mb-2 block">Transparansi Data Kependudukan</span>
                <h1 class="text-4xl md:text-5xl font-bold font-outfit text-white mb-6 leading-tight">Dashboard <span class="text-blue-500">Statistik Desa</span></h1>
                <p class="text-slate-300 text-lg">Visualisasi interaktif data kependudukan, pendidikan, dan pekerjaan untuk mendukung keterbukaan informasi publik.</p>
            </div>

            <!-- Aggregate Counters -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 lg:gap-8 max-w-5xl mx-auto">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 text-center border border-white/10 transform hover:-translate-y-1 transition-transform">
                    <div class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Penduduk</div>
                    <div class="text-4xl font-bold font-outfit text-white">{{ number_format($statistic->total_population, 0, ',', '.') }}</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 text-center border border-white/10 transform hover:-translate-y-1 transition-transform">
                    <div class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Kepala Keluarga</div>
                    <div class="text-4xl font-bold font-outfit text-white">{{ number_format($statistic->total_family, 0, ',', '.') }}</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 text-center border border-white/10 transform hover:-translate-y-1 transition-transform">
                    <div class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">Dusun</div>
                    <div class="text-4xl font-bold font-outfit text-white">{{ number_format($statistic->total_dusun, 0, ',', '.') }}</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 text-center border border-white/10 transform hover:-translate-y-1 transition-transform">
                    <div class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">RW</div>
                    <div class="text-4xl font-bold font-outfit text-white">{{ number_format($statistic->total_rw, 0, ',', '.') }}</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 text-center border border-white/10 transform hover:-translate-y-1 transition-transform">
                    <div class="text-slate-400 text-sm font-semibold uppercase tracking-wider mb-2">RT</div>
                    <div class="text-4xl font-bold font-outfit text-white">{{ number_format($statistic->total_rt, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Charts Section -->
    <section class="py-16 bg-slate-50 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Gender Chart -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 font-outfit">Distribusi Jenis Kelamin</h3>
                    <div id="chart-gender" class="flex justify-center"></div>
                </div>

                <!-- Age Chart -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 font-outfit">Kelompok Usia</h3>
                    <div id="chart-age"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Education Chart (Takes 2 columns) -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 lg:col-span-2">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 font-outfit">Tingkat Pendidikan</h3>
                    <div id="chart-education"></div>
                </div>

                <!-- Religion Chart (Takes 1 column) -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-6 font-outfit">Agama</h3>
                    <div id="chart-religion" class="flex justify-center"></div>
                </div>
            </div>

            <!-- Job Chart -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 mb-6 font-outfit">Mata Pencaharian / Pekerjaan</h3>
                <div id="chart-job"></div>
            </div>

        </div>
    </section>

    <!-- Import ApexCharts -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Common Options
            const commonOptions = {
                chart: {
                    fontFamily: 'Inter, sans-serif',
                    toolbar: { show: false }
                },
                colors: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#f97316', '#64748b']
            };

            // 1. Gender Chart (Donut)
            const genderData = @json($statistic->gender_data);
            const genderOptions = {
                ...commonOptions,
                series: [genderData.laki_laki || 0, genderData.perempuan || 0],
                labels: ['Laki-laki', 'Perempuan'],
                chart: { type: 'donut', height: 350 },
                plotOptions: {
                    pie: { donut: { size: '70%' } }
                },
                dataLabels: { enabled: false },
                legend: { position: 'bottom' },
                colors: ['#3b82f6', '#ec4899'] // Blue and Pink
            };
            new ApexCharts(document.querySelector("#chart-gender"), genderOptions).render();

            // 2. Age Chart (Bar/Column)
            const ageData = @json($statistic->age_data);
            const ageOptions = {
                ...commonOptions,
                series: [{
                    name: 'Jumlah',
                    data: [
                        ageData['0_4'] || 0, 
                        ageData['5_14'] || 0, 
                        ageData['15_39'] || 0, 
                        ageData['40_64'] || 0, 
                        ageData['65_plus'] || 0
                    ]
                }],
                chart: { type: 'bar', height: 350 },
                xaxis: {
                    categories: ['Balita (0-4)', 'Anak (5-14)', 'Pemuda (15-39)', 'Dewasa (40-64)', 'Lansia (65+)'],
                },
                plotOptions: {
                    bar: { borderRadius: 4, horizontal: false, columnWidth: '50%' }
                },
                dataLabels: { enabled: false },
                colors: ['#8b5cf6']
            };
            new ApexCharts(document.querySelector("#chart-age"), ageOptions).render();

            // 3. Education Chart (Bar)
            const eduData = @json($statistic->education_data);
            const eduOptions = {
                ...commonOptions,
                series: [{
                    name: 'Jumlah',
                    data: [
                        eduData['belum_sekolah'] || 0,
                        eduData['tk'] || 0,
                        eduData['sd'] || 0,
                        eduData['smp'] || 0,
                        eduData['sma'] || 0,
                        eduData['d1_d3'] || 0,
                        eduData['s1'] || 0,
                        eduData['s2_s3'] || 0
                    ]
                }],
                chart: { type: 'bar', height: 350 },
                xaxis: {
                    categories: ['Belum Sekolah', 'TK', 'SD', 'SMP', 'SMA', 'Diploma', 'S1', 'S2/S3'],
                },
                plotOptions: {
                    bar: { borderRadius: 4, distributed: true }
                },
                legend: { show: false },
                dataLabels: { enabled: false }
            };
            new ApexCharts(document.querySelector("#chart-education"), eduOptions).render();

            // 4. Religion Chart (Pie)
            const relData = @json($statistic->religion_data);
            const relOptions = {
                ...commonOptions,
                series: [
                    relData['islam'] || 0,
                    relData['kristen'] || 0,
                    relData['katolik'] || 0,
                    relData['hindu'] || 0,
                    relData['buddha'] || 0,
                    relData['konghucu'] || 0
                ],
                labels: ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'],
                chart: { type: 'pie', height: 350 },
                legend: { position: 'bottom' },
                dataLabels: { enabled: false }
            };
            new ApexCharts(document.querySelector("#chart-religion"), relOptions).render();

            // 5. Job Chart (Horizontal Bar)
            const jobData = @json($statistic->job_data);
            const jobOptions = {
                ...commonOptions,
                series: [{
                    name: 'Jumlah',
                    data: [
                        jobData['belum_bekerja'] || 0,
                        jobData['pelajar_mahasiswa'] || 0,
                        jobData['pns'] || 0,
                        jobData['tni_polri'] || 0,
                        jobData['wiraswasta'] || 0,
                        jobData['petani'] || 0,
                        jobData['nelayan'] || 0,
                        jobData['karyawan_swasta'] || 0,
                        jobData['buruh'] || 0,
                        jobData['pensiunan'] || 0,
                        jobData['lainnya'] || 0
                    ]
                }],
                chart: { type: 'bar', height: 400 },
                plotOptions: {
                    bar: { borderRadius: 4, horizontal: true }
                },
                xaxis: {
                    categories: ['Belum Bekerja', 'Pelajar', 'PNS', 'TNI/Polri', 'Wiraswasta', 'Petani', 'Nelayan', 'Karyawan Swasta', 'Buruh', 'Pensiunan', 'Lainnya'],
                },
                dataLabels: { enabled: false },
                colors: ['#10b981']
            };
            new ApexCharts(document.querySelector("#chart-job"), jobOptions).render();
        });
    </script>
    @endpush
</x-public-layout>
