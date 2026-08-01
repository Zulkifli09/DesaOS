<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\JenisSurat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SuratRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'jenis_surat'      => ['required', new Enum(JenisSurat::class)],
            'surat_template_id'=> ['nullable', 'uuid', 'exists:surat_templates,id'],
            'nama_pemohon'     => ['required', 'string', 'max:255'],
            'nik_pemohon'      => ['required', 'string', 'size:16', 'regex:/^[0-9]+$/'],
            'alamat_pemohon'   => ['required', 'string', 'max:1000'],
            'no_hp_pemohon'    => ['nullable', 'string', 'max:20'],
            'keperluan'        => ['required', 'string', 'min:20', 'max:2000'],
            'catatan_pemohon'  => ['nullable', 'string', 'max:2000'],
            'data_tambahan'    => ['nullable', 'array'],
            // Document uploads — optional, multiple files
            'dokumens'         => ['nullable', 'array', 'max:10'],
            'dokumens.*'       => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // 5MB per file
        ];
    }

    public function messages(): array
    {
        return [
            'jenis_surat.required'    => 'Jenis surat wajib dipilih.',
            'nama_pemohon.required'   => 'Nama pemohon wajib diisi.',
            'nik_pemohon.required'    => 'NIK wajib diisi.',
            'nik_pemohon.size'        => 'NIK harus 16 digit.',
            'nik_pemohon.regex'       => 'NIK hanya boleh berisi angka.',
            'alamat_pemohon.required' => 'Alamat pemohon wajib diisi.',
            'keperluan.required'      => 'Keperluan/tujuan surat wajib diisi.',
            'keperluan.min'           => 'Keperluan minimal 20 karakter.',
            'dokumens.*.mimes'        => 'File dokumen harus berformat PDF, JPG, atau PNG.',
            'dokumens.*.max'          => 'Setiap file maksimal 5 MB.',
        ];
    }
}
