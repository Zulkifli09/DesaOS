<?php

declare(strict_types=1);

namespace App\Enums;

enum SuratStatus: string
{
    case Draft = 'draft';
    case Diajukan = 'diajukan';
    case Diverifikasi = 'diverifikasi';
    case Diproses = 'diproses';
    case MenungguPersetujuan = 'menunggu_persetujuan';
    case Selesai = 'selesai';
    case Ditolak = 'ditolak';
    case Revisi = 'revisi';

    public function label(): string
    {
        return match($this) {
            self::Draft               => 'Draft',
            self::Diajukan            => 'Diajukan',
            self::Diverifikasi        => 'Diverifikasi',
            self::Diproses            => 'Diproses',
            self::MenungguPersetujuan => 'Menunggu Persetujuan',
            self::Selesai             => 'Selesai',
            self::Ditolak             => 'Ditolak',
            self::Revisi              => 'Perlu Revisi',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Draft               => 'gray',
            self::Diajukan            => 'blue',
            self::Diverifikasi        => 'cyan',
            self::Diproses            => 'yellow',
            self::MenungguPersetujuan => 'orange',
            self::Selesai             => 'green',
            self::Ditolak             => 'red',
            self::Revisi              => 'purple',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::Draft               => 'pencil',
            self::Diajukan            => 'paper-airplane',
            self::Diverifikasi        => 'check-circle',
            self::Diproses            => 'cog',
            self::MenungguPersetujuan => 'clock',
            self::Selesai             => 'badge-check',
            self::Ditolak             => 'x-circle',
            self::Revisi              => 'refresh',
        };
    }

    public function stepNumber(): int
    {
        return match($this) {
            self::Draft               => 1,
            self::Diajukan            => 2,
            self::Diverifikasi        => 3,
            self::Diproses            => 4,
            self::MenungguPersetujuan => 5,
            self::Selesai             => 6,
            self::Ditolak             => 0,
            self::Revisi              => 0,
        };
    }

    /** Returns the statuses that mark the surat as "active/in-progress" */
    public static function activeStatuses(): array
    {
        return [
            self::Diajukan,
            self::Diverifikasi,
            self::Diproses,
            self::MenungguPersetujuan,
        ];
    }
}
