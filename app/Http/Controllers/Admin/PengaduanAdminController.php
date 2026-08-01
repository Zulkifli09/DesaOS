<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\PengaduanStatus;
use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Services\PengaduanService;
use Illuminate\Http\Request;

class PengaduanAdminController extends Controller
{
    public function __construct(
        protected PengaduanService $pengaduanService,
    ) {}

    public function index(Request $request)
    {
        $pengaduans = $this->pengaduanService->getPaginatedAll(
            15,
            $request->status,
            $request->search
        );
        $stats    = $this->pengaduanService->getStatsAll();
        $statuses = PengaduanStatus::cases();

        return view('admin.pengaduan.index', compact('pengaduans', 'stats', 'statuses'));
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load(['user', 'petugas', 'dokumens', 'komentars.user', 'timelines.user']);

        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Update pengaduan status (admin action).
     */
    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'status'           => 'required|in:' . implode(',', array_column(PengaduanStatus::cases(), 'value')),
            'catatan_petugas'  => 'nullable|string|max:1000',
            'catatan_penolakan'=> 'nullable|required_if:status,ditolak|string|max:1000',
        ]);

        $status = PengaduanStatus::from($request->status);

        $this->pengaduanService->updateStatus(
            pengaduan: $pengaduan,
            newStatus: $status,
            judul:     "Status diperbarui: " . $status->label(),
            deskripsi: $request->catatan_petugas,
            catatanPetugas: $request->catatan_petugas,
            catatanPenolakan: $request->catatan_penolakan,
            petugasId: auth()->id(),
        );

        return redirect()
            ->route('admin.pengaduan.show', $pengaduan->id)
            ->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    /**
     * Add internal staff comment.
     */
    public function addKomentar(Request $request, Pengaduan $pengaduan)
    {
        $request->validate(['komentar' => 'required|string|min:5|max:1000']);

        $isInternal = (bool) $request->boolean('is_internal');
        $this->pengaduanService->addKomentar($pengaduan, auth()->id(), $request->komentar, $isInternal);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }
}
