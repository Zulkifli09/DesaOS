<?php

declare(strict_types=1);

namespace App\Enums;

enum PengaduanKategori: string
{
    case Infrastruktur   = 'infrastruktur';
    case Pelayanan       = 'pelayanan';
    case Keamanan        = 'keamanan';
    case Lingkungan      = 'lingkungan';
    case Sosial          = 'sosial';
    case Administrasi    = 'administrasi';
    case Lainnya         = 'lainnya';

    public function label(): string
    {
        return match($this) {
            self::Infrastruktur => 'Infrastruktur',
            self::Pelayanan     => 'Pelayanan Publik',
            self::Keamanan      => 'Keamanan & Ketertiban',
            self::Lingkungan    => 'Lingkungan Hidup',
            self::Sosial        => 'Sosial Kemasyarakatan',
            self::Administrasi  => 'Administrasi Desa',
            self::Lainnya       => 'Lainnya',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::Infrastruktur => '🏗️',
            self::Pelayanan     => '🏛️',
            self::Keamanan      => '🛡️',
            self::Lingkungan    => '🌿',
            self::Sosial        => '👥',
            self::Administrasi  => '📋',
            self::Lainnya       => '❓',
        };
    }
}
