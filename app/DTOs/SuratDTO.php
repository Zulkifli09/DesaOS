<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\JenisSurat;

class SuratDTO
{
    public function __construct(
        public readonly JenisSurat $jenisSurat,
        public readonly string $userId,
        public readonly string $namaPemohon,
        public readonly string $nikPemohon,
        public readonly string $alamatPemohon,
        public readonly string $keperluan,
        public readonly ?string $noHpPemohon = null,
        public readonly ?array $dataTambahan = null,
        public readonly ?string $catatanPemohon = null,
        public readonly ?string $suratTemplateId = null,
    ) {}

    public static function fromRequest(array $data, string $userId): self
    {
        return new self(
            jenisSurat:      JenisSurat::from($data['jenis_surat']),
            userId:          $userId,
            namaPemohon:     $data['nama_pemohon'],
            nikPemohon:      $data['nik_pemohon'],
            alamatPemohon:   $data['alamat_pemohon'],
            keperluan:       $data['keperluan'],
            noHpPemohon:     $data['no_hp_pemohon'] ?? null,
            dataTambahan:    $data['data_tambahan'] ?? null,
            catatanPemohon:  $data['catatan_pemohon'] ?? null,
            suratTemplateId: $data['surat_template_id'] ?? null,
        );
    }
}
