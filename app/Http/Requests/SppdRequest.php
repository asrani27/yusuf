<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SppdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('sppd')?->id ?? $this->route('sppd');

        return [
            'nomor_sppd' => 'required|string|max:100|unique:sppd,nomor_sppd,'.$id,
            'spt_id' => 'required|exists:spt,id',
            'pegawai_id' => 'required|exists:pegawai,id',
            'tingkat_biaya' => 'nullable|string|max:50',
            'alat_angkut' => 'required|string|max:50',
            'tempat_berangkat' => 'required|string|max:100',
            'tempat_tujuan' => 'required|string|max:100',
            'tanggal_berangkat' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_berangkat',
            'lama_hari' => 'required|integer|min:1',
            'pembebanan_anggaran' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nomor_sppd.required' => 'Nomor SPPD wajib diisi.',
            'nomor_sppd.unique' => 'Nomor SPPD sudah terdaftar.',
            'spt_id.required' => 'SPT wajib dipilih.',
            'pegawai_id.required' => 'Pegawai wajib dipilih.',
            'alat_angkut.required' => 'Alat angkut wajib diisi.',
            'tempat_berangkat.required' => 'Tempat berangkat wajib diisi.',
            'tempat_tujuan.required' => 'Tempat tujuan wajib diisi.',
            'tanggal_berangkat.required' => 'Tanggal berangkat wajib diisi.',
            'tanggal_kembali.required' => 'Tanggal kembali wajib diisi.',
            'pembebanan_anggaran.required' => 'Pembebanan anggaran wajib diisi.',
        ];
    }
}
