<?php

declare(strict_types=1);

namespace App\Enums;

enum JenisSurat: string
{
    case Domisili        = 'domisili';
    case KeteranganUsaha = 'keterangan_usaha';
    case Pengantar       = 'pengantar';
    case TidakMampu      = 'tidak_mampu';
    case Kehilangan      = 'kehilangan';
    case Kelahiran       = 'kelahiran';
    case Kematian        = 'kematian';
    case Lainnya         = 'lainnya';

    public function label(): string
    {
        return match($this) {
            self::Domisili        => 'Surat Domisili',
            self::KeteranganUsaha => 'Surat Keterangan Usaha',
            self::Pengantar       => 'Surat Pengantar',
            self::TidakMampu      => 'Surat Tidak Mampu',
            self::Kehilangan      => 'Surat Kehilangan',
            self::Kelahiran       => 'Surat Kelahiran',
            self::Kematian        => 'Surat Kematian',
            self::Lainnya         => 'Surat Lainnya',
        };
    }

    public function kodePrefix(): string
    {
        return match($this) {
            self::Domisili        => 'DOM',
            self::KeteranganUsaha => 'USH',
            self::Pengantar       => 'PNT',
            self::TidakMampu      => 'TDM',
            self::Kehilangan      => 'KHL',
            self::Kelahiran       => 'LHR',
            self::Kematian        => 'KMT',
            self::Lainnya         => 'LNY',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::Domisili        => '🏠',
            self::KeteranganUsaha => '🏪',
            self::Pengantar       => '📋',
            self::TidakMampu      => '🤝',
            self::Kehilangan      => '🔍',
            self::Kelahiran       => '👶',
            self::Kematian        => '🕊️',
            self::Lainnya         => '📄',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::Domisili        => 'Surat keterangan tempat tinggal/domisili di wilayah desa ini.',
            self::KeteranganUsaha => 'Surat keterangan untuk keperluan usaha/bisnis.',
            self::Pengantar       => 'Surat pengantar untuk keperluan administrasi.',
            self::TidakMampu      => 'Surat keterangan tidak mampu untuk keperluan sosial.',
            self::Kehilangan      => 'Surat keterangan kehilangan dokumen/barang.',
            self::Kelahiran       => 'Surat keterangan kelahiran untuk anak yang baru lahir.',
            self::Kematian        => 'Surat keterangan kematian untuk keperluan administrasi.',
            self::Lainnya         => 'Jenis surat lain sesuai kebutuhan masyarakat.',
        };
    }

    public function estimasiHari(): int
    {
        return match($this) {
            self::Domisili        => 1,
            self::KeteranganUsaha => 2,
            self::Pengantar       => 1,
            self::TidakMampu      => 2,
            self::Kehilangan      => 1,
            self::Kelahiran       => 3,
            self::Kematian        => 2,
            self::Lainnya         => 3,
        };
    }
}
