<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\PengaduanKategori;
use App\Enums\PengaduanPrioritas;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PengaduanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'kategori'  => ['required', new Enum(PengaduanKategori::class)],
            'prioritas' => ['nullable', new Enum(PengaduanPrioritas::class)],
            'judul'     => ['required', 'string', 'min:10', 'max:255'],
            'deskripsi' => ['required', 'string', 'min:50', 'max:5000'],
            'lokasi'    => ['nullable', 'string', 'max:500'],
            'lat'       => ['nullable', 'numeric', 'between:-90,90'],
            'lng'       => ['nullable', 'numeric', 'between:-180,180'],
            'lampiran'  => ['nullable', 'array', 'max:5'],
            'lampiran.*'=> ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'kategori.required' => 'Kategori pengaduan wajib dipilih.',
            'judul.required'    => 'Judul pengaduan wajib diisi.',
            'judul.min'         => 'Judul minimal 10 karakter.',
            'deskripsi.required'=> 'Deskripsi pengaduan wajib diisi.',
            'deskripsi.min'     => 'Deskripsi pengaduan minimal 50 karakter agar dapat diproses dengan baik.',
            'lampiran.*.mimes'  => 'Lampiran harus berformat JPG, PNG, atau PDF.',
            'lampiran.*.max'    => 'Setiap lampiran maksimal 5 MB.',
        ];
    }
}
