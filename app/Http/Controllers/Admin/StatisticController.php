<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageStatistic;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StatisticController extends Controller
{
    public function index(): View
    {
        $statistic = VillageStatistic::first();
        
        // If not exists, create a default one
        if (!$statistic) {
            $statistic = VillageStatistic::create([
                'total_population' => 0,
                'total_family' => 0,
                'total_dusun' => 0,
                'total_rt' => 0,
                'total_rw' => 0,
                'gender_data' => ['laki_laki' => 0, 'perempuan' => 0],
                'education_data' => ['belum_sekolah' => 0, 'tk' => 0, 'sd' => 0, 'smp' => 0, 'sma' => 0, 'd1_d3' => 0, 's1' => 0, 's2_s3' => 0],
                'job_data' => ['belum_bekerja' => 0, 'pelajar_mahasiswa' => 0, 'pns' => 0, 'tni_polri' => 0, 'wiraswasta' => 0, 'petani' => 0, 'nelayan' => 0, 'karyawan_swasta' => 0, 'buruh' => 0, 'pensiunan' => 0, 'lainnya' => 0],
                'age_data' => ['0_4' => 0, '5_14' => 0, '15_39' => 0, '40_64' => 0, '65_plus' => 0],
                'religion_data' => ['islam' => 0, 'kristen' => 0, 'katolik' => 0, 'hindu' => 0, 'buddha' => 0, 'konghucu' => 0],
            ]);
        }

        return view('admin.statistics.index', compact('statistic'));
    }

    public function update(Request $request): RedirectResponse
    {
        $statistic = VillageStatistic::firstOrFail();

        $validated = $request->validate([
            'total_population' => 'required|integer|min:0',
            'total_family' => 'required|integer|min:0',
            'total_dusun' => 'required|integer|min:0',
            'total_rt' => 'required|integer|min:0',
            'total_rw' => 'required|integer|min:0',
            
            'gender_data' => 'required|array',
            'gender_data.*' => 'integer|min:0',
            
            'education_data' => 'required|array',
            'education_data.*' => 'integer|min:0',
            
            'job_data' => 'required|array',
            'job_data.*' => 'integer|min:0',
            
            'age_data' => 'required|array',
            'age_data.*' => 'integer|min:0',
            
            'religion_data' => 'required|array',
            'religion_data.*' => 'integer|min:0',
        ]);

        $statistic->update($validated);

        return redirect()->route('admin.statistics.index')->with('success', 'Data Statistik Desa berhasil diperbarui.');
    }
}
