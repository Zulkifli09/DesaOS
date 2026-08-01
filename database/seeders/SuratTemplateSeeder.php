<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\JenisSurat;
use App\Models\SuratTemplate;
use Illuminate\Database\Seeder;

class SuratTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'jenis_surat'   => JenisSurat::Domisili,
                'persyaratan'   => ['Fotokopi KTP', 'Fotokopi KK', 'Surat permohonan dari pemohon'],
                'estimasi_hari' => 1,
                'urutan'        => 1,
            ],
            [
                'jenis_surat'   => JenisSurat::KeteranganUsaha,
                'persyaratan'   => ['Fotokopi KTP', 'Fotokopi KK', 'Keterangan lokasi usaha', 'Pas foto 3x4'],
                'estimasi_hari' => 2,
                'urutan'        => 2,
            ],
            [
                'jenis_surat'   => JenisSurat::Pengantar,
                'persyaratan'   => ['Fotokopi KTP', 'Keterangan keperluan surat'],
                'estimasi_hari' => 1,
                'urutan'        => 3,
            ],
            [
                'jenis_surat'   => JenisSurat::TidakMampu,
                'persyaratan'   => ['Fotokopi KTP', 'Fotokopi KK', 'Surat pernyataan tidak mampu', 'Rekomendasi RT/RW'],
                'estimasi_hari' => 2,
                'urutan'        => 4,
            ],
            [
                'jenis_surat'   => JenisSurat::Kehilangan,
                'persyaratan'   => ['Fotokopi KTP', 'Laporan kehilangan dari kepolisian (jika ada)', 'Keterangan barang/dokumen yang hilang'],
                'estimasi_hari' => 1,
                'urutan'        => 5,
            ],
            [
                'jenis_surat'   => JenisSurat::Kelahiran,
                'persyaratan'   => ['Surat keterangan lahir dari bidan/rumah sakit', 'Fotokopi KTP kedua orang tua', 'Fotokopi KK', 'Akta nikah orang tua'],
                'estimasi_hari' => 3,
                'urutan'        => 6,
            ],
            [
                'jenis_surat'   => JenisSurat::Kematian,
                'persyaratan'   => ['Surat keterangan kematian dari dokter/rumah sakit', 'Fotokopi KTP almarhum', 'Fotokopi KK', 'Fotokopi KTP pelapor'],
                'estimasi_hari' => 2,
                'urutan'        => 7,
            ],
            [
                'jenis_surat'   => JenisSurat::Lainnya,
                'persyaratan'   => ['Fotokopi KTP', 'Keterangan keperluan surat'],
                'estimasi_hari' => 3,
                'urutan'        => 8,
            ],
        ];

        foreach ($templates as $templateData) {
            $jenis = $templateData['jenis_surat'];
            SuratTemplate::firstOrCreate(
                ['jenis_surat' => $jenis->value],
                [
                    'nama'          => $jenis->label(),
                    'deskripsi'     => $jenis->description(),
                    'persyaratan'   => $templateData['persyaratan'],
                    'estimasi_hari' => $templateData['estimasi_hari'],
                    'is_active'     => true,
                    'urutan'        => $templateData['urutan'],
                ]
            );
        }

        $this->command->info('✅ SuratTemplate: 8 jenis surat berhasil dibuat.');
    }
}
