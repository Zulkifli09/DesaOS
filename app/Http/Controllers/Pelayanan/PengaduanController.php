<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pelayanan;

use App\DTOs\PengaduanDTO;
use App\Enums\PengaduanKategori;
use App\Enums\PengaduanPrioritas;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengaduanRequest;
use App\Models\Pengaduan;
use App\Services\PengaduanService;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function __construct(
        protected PengaduanService $pengaduanService,
    ) {}

    /**
     * List citizen's pengaduan.
     */
    public function index(Request $request)
    {
        $pengaduans = $this->pengaduanService->getPaginatedByUser(
            auth()->id(),
            10,
            $request->status
        );
        $kategoris = PengaduanKategori::cases();

        return view('pelayanan.pengaduan.index', compact('pengaduans', 'kategoris'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $kategoris  = PengaduanKategori::cases();
        $prioritas  = PengaduanPrioritas::cases();

        return view('pelayanan.pengaduan.create', compact('kategoris', 'prioritas'));
    }

    /**
     * Store new pengaduan.
     */
    public function store(PengaduanRequest $request)
    {
        $dto = PengaduanDTO::fromRequest($request->validated(), auth()->id());
        $pengaduan = $this->pengaduanService->create($dto);

        // Handle photo/document uploads
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $this->pengaduanService->uploadDokumen($pengaduan, $file);
            }
        }

        return redirect()
            ->route('pelayanan.pengaduan.show', $pengaduan->id)
            ->with('success', "Pengaduan berhasil dibuat dengan nomor {$pengaduan->nomor_pengaduan}.");
    }

    /**
     * Show pengaduan detail with tracking.
     */
    public function show(Pengaduan $pengaduan)
    {
        $this->authorize('view', $pengaduan);

        $pengaduan->load(['user', 'dokumens', 'publicKomentars.user', 'timelines.user']);

        return view('pelayanan.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Add a komentar from citizen.
     */
    public function addKomentar(Request $request, Pengaduan $pengaduan)
    {
        $this->authorize('view', $pengaduan);

        $request->validate(['komentar' => 'required|string|min:5|max:1000']);

        $this->pengaduanService->addKomentar($pengaduan, auth()->id(), $request->komentar, false);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    /**
     * List riwayat pengaduan.
     */
    public function riwayat(Request $request)
    {
        $pengaduans = $this->pengaduanService->getPaginatedByUser(auth()->id(), 10, $request->status);

        return view('pelayanan.pengaduan.riwayat', compact('pengaduans'));
    }
}
