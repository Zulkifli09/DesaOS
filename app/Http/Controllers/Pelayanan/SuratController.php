<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pelayanan;

use App\DTOs\SuratDTO;
use App\Enums\JenisSurat;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuratRequest;
use App\Models\SuratPermohonan;
use App\Models\SuratTemplate;
use App\Services\SuratService;
use Illuminate\Http\Request;

class SuratController extends Controller
{
    public function __construct(
        protected SuratService $suratService,
    ) {}

    /**
     * List all surat types for citizens to choose from.
     */
    public function index()
    {
        $templates = SuratTemplate::active()->get();
        $jenisSurats = JenisSurat::cases();

        return view('pelayanan.surat.index', compact('templates', 'jenisSurats'));
    }

    /**
     * Show form for creating a new surat of a given type.
     */
    public function create(string $jenis)
    {
        $jenisSurat = JenisSurat::from($jenis);
        $template = SuratTemplate::where('jenis_surat', $jenis)->where('is_active', true)->first();

        return view('pelayanan.surat.create', compact('jenisSurat', 'template'));
    }

    /**
     * Store new surat as draft.
     */
    public function store(SuratRequest $request)
    {
        $dto = SuratDTO::fromRequest($request->validated(), auth()->id());
        $surat = $this->suratService->createDraft($dto);

        // Handle document uploads
        if ($request->hasFile('dokumens')) {
            foreach ($request->file('dokumens') as $key => $file) {
                $this->suratService->uploadDokumen($surat, $file, $key, $key);
            }
        }

        return redirect()
            ->route('pelayanan.surat.show', $surat->id)
            ->with('success', 'Permohonan surat berhasil dibuat sebagai draft.');
    }

    /**
     * Show a surat detail / preview.
     */
    public function show(SuratPermohonan $surat)
    {
        $this->authorize('view', $surat);

        $surat->load(['template', 'dokumens', 'timelines.user', 'approvalWorkflow.stages.user']);

        return view('pelayanan.surat.show', compact('surat'));
    }

    /**
     * Show edit form for draft surat.
     */
    public function edit(SuratPermohonan $surat)
    {
        $this->authorize('update', $surat);

        abort_unless($surat->isEditable(), 403, 'Surat yang sudah diajukan tidak dapat diedit.');

        $template = SuratTemplate::where('jenis_surat', $surat->jenis_surat->value)->first();

        return view('pelayanan.surat.edit', compact('surat', 'template'));
    }

    /**
     * Update a draft surat.
     */
    public function update(SuratRequest $request, SuratPermohonan $surat)
    {
        $this->authorize('update', $surat);
        abort_unless($surat->isEditable(), 403, 'Surat ini tidak dapat diedit.');

        $dto = SuratDTO::fromRequest($request->validated(), auth()->id());
        $this->suratService->suratRepository->update($surat, [
            'nama_pemohon'    => $dto->namaPemohon,
            'nik_pemohon'     => $dto->nikPemohon,
            'alamat_pemohon'  => $dto->alamatPemohon,
            'no_hp_pemohon'   => $dto->noHpPemohon,
            'keperluan'       => $dto->keperluan,
            'data_tambahan'   => $dto->dataTambahan,
            'catatan_pemohon' => $dto->catatanPemohon,
        ]);

        return redirect()
            ->route('pelayanan.surat.show', $surat->id)
            ->with('success', 'Draft berhasil diperbarui.');
    }

    /**
     * Submit a draft surat for processing.
     */
    public function submit(SuratPermohonan $surat)
    {
        $this->authorize('update', $surat);
        abort_unless($surat->isEditable(), 403, 'Surat ini tidak dapat diajukan.');

        $surat = $this->suratService->submitSurat($surat);

        return redirect()
            ->route('pelayanan.surat.show', $surat->id)
            ->with('success', "Permohonan berhasil diajukan dengan nomor {$surat->nomor_surat}.");
    }

    /**
     * Download PDF of a completed surat.
     */
    public function downloadPdf(SuratPermohonan $surat)
    {
        $this->authorize('view', $surat);

        abort_unless($surat->status->value === 'selesai', 403, 'PDF hanya tersedia untuk surat yang telah selesai.');

        return view('pelayanan.surat.pdf', compact('surat'));
    }

    /**
     * List riwayat surat for the logged-in user.
     */
    public function riwayat(Request $request)
    {
        $surats = $this->suratService->getPaginatedByUser(
            auth()->id(),
            10,
            $request->status
        );

        return view('pelayanan.surat.riwayat', compact('surats'));
    }

    /**
     * Delete draft surat.
     */
    public function destroy(SuratPermohonan $surat)
    {
        $this->authorize('delete', $surat);

        $this->suratService->deleteDraft($surat);

        return redirect()
            ->route('pelayanan.surat.riwayat')
            ->with('success', 'Draft surat berhasil dihapus.');
    }
}
