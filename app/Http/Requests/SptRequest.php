<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('spt')?->id ?? $this->route('spt');

        return [
            'nomor_spt' => 'required|string|max:100|unique:spt,nomor_spt,'.$id,
            'pejabat_id' => 'required|exists:pegawai,id',
            'tujuan_id' => 'required|exists:tujuan_tugas,id',
            'maksud_perjalanan' => 'required|string',
            'dasar_penugasan' => 'nullable|string',
            'tanggal_berangkat' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_berangkat',
            'lama_hari' => 'required|integer|min:1',
            'transportasi' => 'required|string|max:50',
            'status_spt' => 'nullable|in:draft,diajukan,disetujui,ditolak',
            'pengikut' => 'required|array|min:1',
            'pengikut.*.pegawai_id' => 'required|exists:pegawai,id',
            'pengikut.*.peran_tugas' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'nomor_spt.required' => 'Nomor SPT wajib diisi.',
            'nomor_spt.unique' => 'Nomor SPT sudah terdaftar.',
            'pejabat_id.required' => 'Pejabat penandatangan wajib dipilih.',
            'tujuan_id.required' => 'Tujuan tugas wajib dipilih.',
            'maksud_perjalanan.required' => 'Maksud perjalanan wajib diisi.',
            'tanggal_berangkat.required' => 'Tanggal berangkat wajib diisi.',
            'tanggal_kembali.required' => 'Tanggal kembali wajib diisi.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali harus setelah atau sama dengan tanggal berangkat.',
            'lama_hari.required' => 'Lama hari wajib diisi.',
            'transportasi.required' => 'Alat transportasi wajib dipilih.',
            'pengikut.required' => 'Minimal satu pegawai harus ditugaskan.',
            'pengikut.min' => 'Minimal satu pegawai harus ditugaskan.',
            'pengikut.*.pegawai_id.required' => 'Pegawai wajib dipilih.',
            'pengikut.*.peran_tugas.required' => 'Peran tugas wajib diisi.',
        ];
    }
}
