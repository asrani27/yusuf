<?php

namespace Database\Seeders;

use App\Models\TujuanTugas;
use Illuminate\Database\Seeder;

class TujuanTugasSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kota_tujuan' => 'Palangka Raya',
                'provinsi_tujuan' => 'Kalimantan Tengah',
                'instansi_tujuan' => 'Dinas Kominfo Provinsi Kalimantan Tengah',
                'alamat_tujuan' => 'Jl. Tjilik Riwut Km 3.5, Palangka Raya',
            ],
            [
                'kota_tujuan' => 'Jakarta',
                'provinsi_tujuan' => 'DKI Jakarta',
                'instansi_tujuan' => 'Kementerian Komunikasi dan Informatika RI',
                'alamat_tujuan' => 'Jl. Medan Merdeka Barat No.9, Jakarta Pusat',
            ],
            [
                'kota_tujuan' => 'Banjarmasin',
                'provinsi_tujuan' => 'Kalimantan Selatan',
                'instansi_tujuan' => 'Dinas Kominfo Provinsi Kalimantan Selatan',
                'alamat_tujuan' => 'Jl. Jend. Sudirman No. 10, Banjarmasin',
            ],
            [
                'kota_tujuan' => 'Surabaya',
                'provinsi_tujuan' => 'Jawa Timur',
                'instansi_tujuan' => 'Badan Siber dan Sandi Negara Regional Jawa Timur',
                'alamat_tujuan' => 'Jl. Raya Darmo No. 68, Surabaya',
            ],
            [
                'kota_tujuan' => 'Banjarbaru',
                'provinsi_tujuan' => 'Kalimantan Selatan',
                'instansi_tujuan' => 'Balai Pelatihan SDM Kominfo Regional Kalimantan',
                'alamat_tujuan' => 'Jl. Panglima Batur No. 2, Banjarbaru',
            ],
        ];

        foreach ($data as $item) {
            TujuanTugas::create($item);
        }
    }
}
