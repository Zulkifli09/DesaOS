<?php

declare(strict_types=1);

namespace App\Enums;

enum PengaduanStatus: string
{
    case Menunggu   = 'menunggu';
    case Diproses   = 'diproses';
    case Diteruskan = 'diteruskan';
    case Selesai    = 'selesai';
    case Ditolak    = 'ditolak';

    public function label(): string
    {
        return match($this) {
            self::Menunggu   => 'Menunggu',
            self::Diproses   => 'Diproses',
            self::Diteruskan => 'Diteruskan',
            self::Selesai    => 'Selesai',
            self::Ditolak    => 'Ditolak',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Menunggu   => 'yellow',
            self::Diproses   => 'blue',
            self::Diteruskan => 'purple',
            self::Selesai    => 'green',
            self::Ditolak    => 'red',
        };
    }
}
