<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        Pegawai::create([
            'nip' => '197605152000031005',
            'nama_pegawai' => 'Ir. H. Ahmad Fauzi, M.T.',
            'tempat_lahir' => 'Kuala Kapuas',
            'tanggal_lahir' => '1976-05-15',
            'jenis_kelamin' => 'L',
            'pangkat_golongan' => 'Pembina Utama Muda / IV/c',
            'jabatan' => 'Kepala Dinas Komunikasi, Informatika, Statistik dan Persandian',
            'unit_kerja' => 'DISKOMINFOSANTIK Kab. Kapuas',
            'nomor_hp' => '081234567890',
            'alamat' => 'Jl. Pemuda No. 1, Kuala Kapuas',
            'is_pejabat' => true,
            'nomor_sk_pejabat' => 'SK.821.2/001/BKD/2023',
            'status_pegawai' => 'PNS',
        ]);

        Pegawai::create([
            'nip' => '198003221005021003',
            'nama_pegawai' => 'Drs. Bambang Suryanto, M.Si.',
            'tempat_lahir' => 'Banjarmasin',
            'tanggal_lahir' => '1980-03-22',
            'jenis_kelamin' => 'L',
            'pangkat_golongan' => 'Pembina / IV/a',
            'jabatan' => 'Sekretaris Dinas',
            'unit_kerja' => 'DISKOMINFOSANTIK Kab. Kapuas',
            'nomor_hp' => '081234567891',
            'alamat' => 'Jl. Merdeka No. 45, Kuala Kapuas',
            'is_pejabat' => true,
            'nomor_sk_pejabat' => 'SK.821.2/002/BKD/2023',
            'status_pegawai' => 'PNS',
        ]);

        Pegawai::create([
            'nip' => '198507101010011001',
            'nama_pegawai' => 'Rina Wulandari, S.Kom., M.T.I.',
            'tempat_lahir' => 'Palangka Raya',
            'tanggal_lahir' => '1985-07-10',
            'jenis_kelamin' => 'P',
            'pangkat_golongan' => 'Penata Tk.I / III/d',
            'jabatan' => 'Kepala Bidang Teknologi Informasi',
            'unit_kerja' => 'DISKOMINFOSANTIK Kab. Kapuas',
            'nomor_hp' => '081234567892',
            'alamat' => 'Jl. Diponegoro No. 12, Kuala Kapuas',
            'is_pejabat' => false,
            'status_pegawai' => 'PNS',
        ]);

        Pegawai::create([
            'nip' => '199001152015041001',
            'nama_pegawai' => 'Muhammad Ridwan, S.T.',
            'tempat_lahir' => 'Kuala Kapuas',
            'tanggal_lahir' => '1990-01-15',
            'jenis_kelamin' => 'L',
            'pangkat_golongan' => 'Penata Muda / III/a',
            'jabatan' => 'Analis Sistem Informasi',
            'unit_kerja' => 'DISKOMINFOSANTIK Kab. Kapuas',
            'nomor_hp' => '081234567893',
            'alamat' => 'Jl. Kartini No. 8, Kuala Kapuas',
            'is_pejabat' => false,
            'status_pegawai' => 'PNS',
        ]);

        Pegawai::create([
            'nip' => '199205201018012001',
            'nama_pegawai' => 'Siti Nurhaliza, A.Md.',
            'tempat_lahir' => 'Kapuas',
            'tanggal_lahir' => '1992-05-20',
            'jenis_kelamin' => 'P',
            'pangkat_golongan' => 'Pengatur Tk.I / II/d',
            'jabatan' => 'Pranata Komputer',
            'unit_kerja' => 'DISKOMINFOSANTIK Kab. Kapuas',
            'nomor_hp' => '081234567894',
            'alamat' => 'Jl. Sudirman No. 22, Kuala Kapuas',
            'is_pejabat' => false,
            'status_pegawai' => 'PPPK',
        ]);
    }
}
