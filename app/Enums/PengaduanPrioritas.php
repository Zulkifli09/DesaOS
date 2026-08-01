<?php

declare(strict_types=1);

namespace App\Enums;

enum PengaduanPrioritas: string
{
    case Rendah  = 'rendah';
    case Sedang  = 'sedang';
    case Tinggi  = 'tinggi';
    case Mendesak = 'mendesak';

    public function label(): string
    {
        return match($this) {
            self::Rendah   => 'Rendah',
            self::Sedang   => 'Sedang',
            self::Tinggi   => 'Tinggi',
            self::Mendesak => 'Mendesak',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Rendah   => 'green',
            self::Sedang   => 'yellow',
            self::Tinggi   => 'orange',
            self::Mendesak => 'red',
        };
    }
}
