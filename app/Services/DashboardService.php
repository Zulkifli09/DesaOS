<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\JenisSurat;
use App\Enums\SuratStatus;
use App\Enums\PengaduanStatus;
use App\Models\SuratPermohonan;
use App\Models\Pengaduan;
use App\Models\SuratTemplate;
use App\Models\ServiceBanner;
use App\Models\ServiceAnnouncement;
use App\Models\ServiceFaq;

class DashboardService
{
    public function __construct(
        protected NotificationService $notificationService,
    ) {}

    /**
     * Get complete dashboard data for a citizen user.
     */
    public function getDashboardData(string $userId): array
    {
        return [
            'stats'              => $this->getUserStats($userId),
            'recent_surat'       => $this->getRecentSurat($userId),
            'recent_pengaduan'   => $this->getRecentPengaduan($userId),
            'active_surat'       => $this->getActiveSurat($userId),
            'banners'            => $this->getActiveBanners(),
            'announcements'      => $this->getActiveAnnouncements(),
            'surat_templates'    => $this->getSuratTemplates(),
            'faqs'               => $this->getFaqs(),
            'unread_count'       => $this->notificationService->getUnreadCount($userId),
        ];
    }

    /**
     * Get admin-facing dashboard statistics.
     */
    public function getAdminStats(): array
    {
        return [
            'total_surat'           => SuratPermohonan::count(),
            'surat_pending'         => SuratPermohonan::where('status', SuratStatus::Diajukan->value)->count(),
            'surat_diproses'        => SuratPermohonan::whereIn('status', SuratStatus::activeStatuses())->count(),
            'surat_selesai'         => SuratPermohonan::where('status', SuratStatus::Selesai->value)->count(),
            'total_pengaduan'       => Pengaduan::count(),
            'pengaduan_pending'     => Pengaduan::where('status', PengaduanStatus::Menunggu->value)->count(),
            'pengaduan_diproses'    => Pengaduan::where('status', PengaduanStatus::Diproses->value)->count(),
            'pengaduan_selesai'     => Pengaduan::where('status', PengaduanStatus::Selesai->value)->count(),
        ];
    }

    private function getUserStats(string $userId): array
    {
        $suratStats = SuratPermohonan::where('user_id', $userId)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $pengaduanStats = Pengaduan::where('user_id', $userId)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return [
            'surat_total'    => array_sum($suratStats),
            'surat_proses'   => array_sum(array_filter($suratStats, fn($k) => in_array($k, ['diajukan', 'diverifikasi', 'diproses', 'menunggu_persetujuan']), ARRAY_FILTER_USE_KEY)),
            'surat_selesai'  => $suratStats['selesai'] ?? 0,
            'pengaduan_total'=> array_sum($pengaduanStats),
            'pengaduan_proses'=> ($pengaduanStats['diproses'] ?? 0) + ($pengaduanStats['diteruskan'] ?? 0),
            'pengaduan_selesai'=> $pengaduanStats['selesai'] ?? 0,
        ];
    }

    private function getRecentSurat(string $userId)
    {
        return SuratPermohonan::with('template')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();
    }

    private function getRecentPengaduan(string $userId)
    {
        return Pengaduan::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();
    }

    private function getActiveSurat(string $userId)
    {
        return SuratPermohonan::with('template')
            ->where('user_id', $userId)
            ->whereIn('status', array_map(fn($s) => $s->value, SuratStatus::activeStatuses()))
            ->latest()
            ->take(3)
            ->get();
    }

    private function getActiveBanners()
    {
        return ServiceBanner::active()->take(5)->get();
    }

    private function getActiveAnnouncements()
    {
        return ServiceAnnouncement::active()->latest()->take(5)->get();
    }

    private function getSuratTemplates()
    {
        return SuratTemplate::active()->get();
    }

    private function getFaqs()
    {
        return ServiceFaq::active()->take(8)->get();
    }
}
