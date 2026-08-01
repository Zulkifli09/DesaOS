<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SuratPermohonan;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    /**
     * Generate a secure verification hash for a surat.
     */
    public function generateHash(string $suratId, string $nomorSurat): string
    {
        $payload = $suratId . $nomorSurat . config('app.key') . 'desa-os-qr-salt';
        return hash('sha256', $payload);
    }

    /**
     * Generate QR code PNG image and store it, return the path.
     */
    public function generateQrImage(string $url, string $suratId): string
    {
        $directory = "surat/qrcode";
        $filename  = "{$suratId}.png";
        $fullPath  = "public/{$directory}/{$filename}";

        Storage::makeDirectory("public/{$directory}");

        $image = QrCode::format('png')
            ->size(300)
            ->errorCorrection('H')
            ->margin(1)
            ->generate($url);

        Storage::put($fullPath, $image);

        return "{$directory}/{$filename}";
    }

    /**
     * Generate inline base64 QR code string for PDF embedding.
     */
    public function generateBase64QrCode(string $url): string
    {
        $image = QrCode::format('png')
            ->size(200)
            ->errorCorrection('H')
            ->margin(1)
            ->generate($url);

        return 'data:image/png;base64,' . base64_encode($image);
    }

    /**
     * Verify a surat via its hash — returns true if valid.
     */
    public function verify(SuratPermohonan $surat, string $hash): bool
    {
        return $surat->verification_hash === $hash
            && $surat->status->value === 'selesai';
    }
}
