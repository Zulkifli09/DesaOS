<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\SuratPermohonan;
use App\Models\SuratVerifikasiLog;
use App\Services\QrCodeService;

class VerifikasiController extends Controller
{
    public function __construct(
        protected QrCodeService $qrCodeService,
    ) {}

    /**
     * Public verification page — accessible without login.
     */
    public function show(string $hash)
    {
        $surat = SuratPermohonan::with(['template', 'user'])
            ->where('verification_hash', $hash)
            ->first();

        $isValid = false;
        $message = '';

        if (!$surat) {
            $message = 'Dokumen tidak ditemukan. Hash verifikasi tidak valid.';
        } elseif ($surat->status->value !== 'selesai') {
            $isValid = false;
            $message = 'Dokumen ini belum mendapatkan persetujuan akhir.';
        } else {
            $isValid = $this->qrCodeService->verify($surat, $hash);
            $message = $isValid
                ? 'Dokumen ini valid dan resmi diterbitkan oleh Pemerintah Desa.'
                : 'Verifikasi gagal. Dokumen mungkin telah dimanipulasi.';
        }

        // Log the verification attempt
        if ($surat) {
            SuratVerifikasiLog::create([
                'surat_permohonan_id' => $surat->id,
                'verification_hash'   => $hash,
                'ip_address'          => request()->ip(),
                'user_agent'          => request()->userAgent(),
                'is_valid'            => $isValid,
                'catatan'             => $message,
            ]);
        }

        return view('verifikasi.show', compact('surat', 'isValid', 'message', 'hash'));
    }
}
