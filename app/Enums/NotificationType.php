<?php

declare(strict_types=1);

namespace App\Enums;

enum NotificationType: string
{
    case SuratDibuat        = 'surat_dibuat';
    case SuratDiverifikasi  = 'surat_diverifikasi';
    case SuratDisetujui     = 'surat_disetujui';
    case SuratDitolak       = 'surat_ditolak';
    case SuratSelesai       = 'surat_selesai';
    case SuratPerluRevisi   = 'surat_perlu_revisi';
    case PengaduanDiterima  = 'pengaduan_diterima';
    case PengaduanDiproses  = 'pengaduan_diproses';
    case PengaduanSelesai   = 'pengaduan_selesai';
    case PengaduanDitolak   = 'pengaduan_ditolak';
    case Pengumuman         = 'pengumuman';
    case Reminder           = 'reminder';
    case Sistem             = 'sistem';

    public function label(): string
    {
        return match($this) {
            self::SuratDibuat       => 'Surat Dibuat',
            self::SuratDiverifikasi => 'Surat Diverifikasi',
            self::SuratDisetujui    => 'Surat Disetujui',
            self::SuratDitolak      => 'Surat Ditolak',
            self::SuratSelesai      => 'Surat Selesai',
            self::SuratPerluRevisi  => 'Surat Perlu Revisi',
            self::PengaduanDiterima => 'Pengaduan Diterima',
            self::PengaduanDiproses => 'Pengaduan Diproses',
            self::PengaduanSelesai  => 'Pengaduan Selesai',
            self::PengaduanDitolak  => 'Pengaduan Ditolak',
            self::Pengumuman        => 'Pengumuman',
            self::Reminder          => 'Pengingat',
            self::Sistem            => 'Sistem',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::SuratDibuat, self::SuratDiverifikasi, 
            self::SuratDisetujui, self::SuratDitolak,
            self::SuratSelesai, self::SuratPerluRevisi => 'document-text',
            self::PengaduanDiterima, self::PengaduanDiproses,
            self::PengaduanSelesai, self::PengaduanDitolak => 'chat-bubble-left-right',
            self::Pengumuman        => 'megaphone',
            self::Reminder          => 'clock',
            self::Sistem            => 'cog-6-tooth',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::SuratDibuat       => 'blue',
            self::SuratDiverifikasi => 'cyan',
            self::SuratDisetujui    => 'green',
            self::SuratDitolak      => 'red',
            self::SuratSelesai      => 'emerald',
            self::SuratPerluRevisi  => 'purple',
            self::PengaduanDiterima => 'blue',
            self::PengaduanDiproses => 'yellow',
            self::PengaduanSelesai  => 'green',
            self::PengaduanDitolak  => 'red',
            self::Pengumuman        => 'orange',
            self::Reminder          => 'indigo',
            self::Sistem            => 'gray',
        };
    }
}
