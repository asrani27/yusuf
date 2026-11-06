<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('pegawai')?->id ?? $this->route('pegawai');

        return [
            'nip' => 'required|string|max:18|unique:pegawai,nip,'.$id,
            'nama_pegawai' => 'required|string|max:100',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'pangkat_golongan' => 'required|string|max:50',
            'jabatan' => 'required|string|max:100',
            'unit_kerja' => 'required|string|max:100',
            'nomor_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'is_pejabat' => 'boolean',
            'nomor_sk_pejabat' => 'nullable|string|max:100',
            'status_pegawai' => 'required|in:PNS,PPPK,Honorer',
        ];
    }

    public function messages(): array
    {
        return [
            'nip.required' => 'NIP wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'nama_pegawai.required' => 'Nama pegawai wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'pangkat_golongan.required' => 'Pangkat/Golongan wajib diisi.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'unit_kerja.required' => 'Unit kerja wajib diisi.',
        ];
    }
}
