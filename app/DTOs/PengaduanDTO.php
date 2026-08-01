<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\PengaduanKategori;
use App\Enums\PengaduanPrioritas;

class PengaduanDTO
{
    public function __construct(
        public readonly string $userId,
        public readonly PengaduanKategori $kategori,
        public readonly PengaduanPrioritas $prioritas,
        public readonly string $judul,
        public readonly string $deskripsi,
        public readonly ?string $lokasi = null,
        public readonly ?float $lat = null,
        public readonly ?float $lng = null,
    ) {}

    public static function fromRequest(array $data, string $userId): self
    {
        return new self(
            userId:   $userId,
            kategori: PengaduanKategori::from($data['kategori']),
            prioritas: PengaduanPrioritas::from($data['prioritas'] ?? 'sedang'),
            judul:    $data['judul'],
            deskripsi: $data['deskripsi'],
            lokasi:   $data['lokasi'] ?? null,
            lat:      isset($data['lat']) ? (float) $data['lat'] : null,
            lng:      isset($data['lng']) ? (float) $data['lng'] : null,
        );
    }
}
