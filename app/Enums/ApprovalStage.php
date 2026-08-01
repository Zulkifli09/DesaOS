<?php

declare(strict_types=1);

namespace App\Enums;

enum ApprovalStage: string
{
    case Operator  = 'operator';
    case Kasi      = 'kasi';
    case Sekdes    = 'sekdes';
    case KepDes    = 'kepala_desa';

    public function label(): string
    {
        return match($this) {
            self::Operator => 'Operator Pelayanan',
            self::Kasi     => 'Kepala Seksi (Kasi)',
            self::Sekdes   => 'Sekretaris Desa',
            self::KepDes   => 'Kepala Desa',
        };
    }

    public function order(): int
    {
        return match($this) {
            self::Operator => 1,
            self::Kasi     => 2,
            self::Sekdes   => 3,
            self::KepDes   => 4,
        };
    }

    public function roleRequired(): string
    {
        return match($this) {
            self::Operator => 'operator',
            self::Kasi     => 'kasi',
            self::Sekdes   => 'sekretaris_desa',
            self::KepDes   => 'kepala_desa',
        };
    }
}
