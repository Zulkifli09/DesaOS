<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Notifikasi;
use App\Models\Pengaduan;
use App\Models\SuratPermohonan;
use App\Enums\NotificationType;
use App\Enums\SuratStatus;
use App\Enums\PengaduanStatus;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Send surat status notification to the citizen (pemohon).
     */
    public function notifySuratStatus(SuratPermohonan $surat, SuratStatus $status): Notifikasi
    {
        $type = $this->suratStatusToType($status);

        $notif = Notifikasi::create([
            'user_id'          => $surat->user_id,
            'type'             => $type->value,
            'judul'            => $this->buildSuratJudul($surat, $status),
            'pesan'            => $this->buildSuratPesan($surat, $status),
            'url'              => route('pelayanan.surat.show', $surat->id),
            'data'             => [
                'surat_id'     => $surat->id,
                'nomor_surat'  => $surat->nomor_surat,
                'jenis_surat'  => $surat->jenis_surat?->label(),
            ],
            'channel'          => 'database',
            'notifiable_type'  => SuratPermohonan::class,
            'notifiable_id'    => $surat->id,
        ]);

        // Email notification
        $this->sendEmailIfEnabled($surat->user, $notif);

        // WhatsApp — stub, ready to plug in
        $this->sendWhatsAppIfEnabled($surat->user, $notif);

        return $notif;
    }

    /**
     * Send pengaduan status notification to the citizen.
     */
    public function notifyPengaduanStatus(Pengaduan $pengaduan, PengaduanStatus $status): Notifikasi
    {
        $type = $this->pengaduanStatusToType($status);

        $notif = Notifikasi::create([
            'user_id'          => $pengaduan->user_id,
            'type'             => $type->value,
            'judul'            => "Pengaduan #{$pengaduan->nomor_pengaduan} — " . $status->label(),
            'pesan'            => $this->buildPengaduanPesan($pengaduan, $status),
            'url'              => route('pelayanan.pengaduan.show', $pengaduan->id),
            'data'             => [
                'pengaduan_id'    => $pengaduan->id,
                'nomor_pengaduan' => $pengaduan->nomor_pengaduan,
                'judul'           => $pengaduan->judul,
            ],
            'channel'          => 'database',
            'notifiable_type'  => Pengaduan::class,
            'notifiable_id'    => $pengaduan->id,
        ]);

        $this->sendEmailIfEnabled($pengaduan->user, $notif);
        $this->sendWhatsAppIfEnabled($pengaduan->user, $notif);

        return $notif;
    }

    /**
     * Create a generic notification for a user.
     */
    public function create(
        string $userId,
        NotificationType $type,
        string $judul,
        string $pesan,
        ?string $url = null,
        ?array $data = null,
    ): Notifikasi {
        return Notifikasi::create([
            'user_id' => $userId,
            'type'    => $type->value,
            'judul'   => $judul,
            'pesan'   => $pesan,
            'url'     => $url,
            'data'    => $data,
            'channel' => 'database',
        ]);
    }

    /**
     * Get unread count for a user.
     */
    public function getUnreadCount(string $userId): int
    {
        return Notifikasi::forUser($userId)->unread()->count();
    }

    /**
     * Mark all notifications as read for a user.
     */
    public function markAllAsRead(string $userId): int
    {
        return Notifikasi::forUser($userId)->unread()->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead(Notifikasi $notifikasi): bool
    {
        return $notifikasi->markAsRead();
    }

    // ----- Private helpers -----

    private function suratStatusToType(SuratStatus $status): NotificationType
    {
        return match($status) {
            SuratStatus::Diajukan            => NotificationType::SuratDibuat,
            SuratStatus::Diverifikasi        => NotificationType::SuratDiverifikasi,
            SuratStatus::MenungguPersetujuan => NotificationType::SuratDisetujui,
            SuratStatus::Selesai             => NotificationType::SuratSelesai,
            SuratStatus::Ditolak             => NotificationType::SuratDitolak,
            SuratStatus::Revisi              => NotificationType::SuratPerluRevisi,
            default                          => NotificationType::Sistem,
        };
    }

    private function pengaduanStatusToType(PengaduanStatus $status): NotificationType
    {
        return match($status) {
            PengaduanStatus::Menunggu   => NotificationType::PengaduanDiterima,
            PengaduanStatus::Diproses   => NotificationType::PengaduanDiproses,
            PengaduanStatus::Diteruskan => NotificationType::PengaduanDiproses,
            PengaduanStatus::Selesai    => NotificationType::PengaduanSelesai,
            PengaduanStatus::Ditolak    => NotificationType::PengaduanDitolak,
        };
    }

    private function buildSuratJudul(SuratPermohonan $surat, SuratStatus $status): string
    {
        $nomor = $surat->nomor_surat ?? '-';
        return "{$surat->jenis_surat?->label()} #{$nomor} — " . $status->label();
    }

    private function buildSuratPesan(SuratPermohonan $surat, SuratStatus $status): string
    {
        return match($status) {
            SuratStatus::Diajukan    => "Permohonan {$surat->jenis_surat?->label()} Anda telah berhasil diajukan. Silakan pantau status permohonan secara berkala.",
            SuratStatus::Diverifikasi=> "Permohonan Anda telah diverifikasi oleh operator dan sedang diproses lebih lanjut.",
            SuratStatus::Selesai     => "Selamat! {$surat->jenis_surat?->label()} Anda telah selesai diproses. Silakan unduh surat Anda.",
            SuratStatus::Ditolak     => "Permohonan Anda ditolak. Alasan: {$surat->catatan_penolakan}",
            SuratStatus::Revisi      => "Permohonan Anda perlu direvisi. Catatan: {$surat->catatan_operator}",
            default                  => "Status permohonan surat Anda telah diperbarui menjadi: " . $status->label(),
        };
    }

    private function buildPengaduanPesan(Pengaduan $pengaduan, PengaduanStatus $status): string
    {
        return match($status) {
            PengaduanStatus::Menunggu   => "Pengaduan '{$pengaduan->judul}' Anda telah diterima. Kami akan segera menindaklanjuti.",
            PengaduanStatus::Diproses   => "Pengaduan Anda sedang dalam proses penanganan oleh petugas.",
            PengaduanStatus::Diteruskan => "Pengaduan Anda telah diteruskan ke pihak yang berwenang untuk penanganan lebih lanjut.",
            PengaduanStatus::Selesai    => "Pengaduan Anda telah selesai ditangani. Terima kasih atas partisipasi Anda.",
            PengaduanStatus::Ditolak    => "Pengaduan Anda tidak dapat ditindaklanjuti. Alasan: {$pengaduan->catatan_penolakan}",
        };
    }

    /**
     * Send email notification — only if user has email verified and feature is enabled.
     */
    private function sendEmailIfEnabled(mixed $user, Notifikasi $notif): void
    {
        // Email notification implementation
        // Currently a no-op stub — implement when email config is ready
        // Mail::to($user->email)->queue(new SuratStatusMail($notif));
    }

    /**
     * WhatsApp notification stub — ready to plug in Fonnte/Wablas/etc.
     */
    private function sendWhatsAppIfEnabled(mixed $user, Notifikasi $notif): void
    {
        // WhatsApp notification stub — plug in your WA provider here
        // Example: FonteService::send($user->phone, $notif->pesan);
    }
}
