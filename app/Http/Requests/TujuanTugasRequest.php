<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TujuanTugasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kota_tujuan' => 'required|string|max:50',
            'provinsi_tujuan' => 'required|string|max:50',
            'instansi_tujuan' => 'required|string|max:150',
            'alamat_tujuan' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'kota_tujuan.required' => 'Kota tujuan wajib diisi.',
            'provinsi_tujuan.required' => 'Provinsi tujuan wajib diisi.',
            'instansi_tujuan.required' => 'Instansi tujuan wajib diisi.',
        ];
    }
}
