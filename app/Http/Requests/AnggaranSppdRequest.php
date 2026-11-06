<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnggaranSppdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uang_harian' => 'required|numeric|min:0',
            'biaya_transportasi' => 'required|numeric|min:0',
            'biaya_penginapan' => 'required|numeric|min:0',
            'biaya_taksi' => 'required|numeric|min:0',
            'biaya_representasi' => 'required|numeric|min:0',
            'biaya_lainnya' => 'required|numeric|min:0',
            'sumber_dana' => 'required|string|max:50',
            'kode_rekening' => 'required|string|max:50',
            'tahun_anggaran' => 'required|digits:4',
        ];
    }

    public function messages(): array
    {
        return [
            'uang_harian.required' => 'Uang harian wajib diisi.',
            'biaya_transportasi.required' => 'Biaya transportasi wajib diisi.',
            'biaya_penginapan.required' => 'Biaya penginapan wajib diisi.',
            'sumber_dana.required' => 'Sumber dana wajib diisi.',
            'kode_rekening.required' => 'Kode rekening wajib diisi.',
            'tahun_anggaran.required' => 'Tahun anggaran wajib diisi.',
        ];
    }
}
