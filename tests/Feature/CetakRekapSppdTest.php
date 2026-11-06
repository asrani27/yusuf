<?php

use App\Models\AnggaranSppd;
use App\Models\Pegawai;
use App\Models\Sppd;
use App\Models\Spt;
use App\Models\TujuanTugas;
use App\Models\User;
use App\Models\VerifikasiSppd;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->pejabat = Pegawai::create([
        'nip' => '198001012005011001',
        'nama_pegawai' => 'Drs. Pejabat Pengesah, M.Si',
        'tempat_lahir' => 'Kuala Kapuas',
        'tanggal_lahir' => '1980-01-01',
        'jenis_kelamin' => 'L',
        'pangkat_golongan' => 'Pembina Utama / IV/c',
        'jabatan' => 'Kepala Dinas',
        'unit_kerja' => 'DISKOMINFOSANTIK',
        'is_pejabat' => true,
        'status_pegawai' => 'PNS',
    ]);

    $this->pegawai = Pegawai::create([
        'nip' => '199001012015011002',
        'nama_pegawai' => 'Budi Santoso, S.Kom',
        'tempat_lahir' => 'Kuala Kapuas',
        'tanggal_lahir' => '1990-01-01',
        'jenis_kelamin' => 'L',
        'pangkat_golongan' => 'Penata Muda / III/a',
        'jabatan' => 'Pranata Komputer',
        'unit_kerja' => 'DISKOMINFOSANTIK',
        'is_pejabat' => false,
        'status_pegawai' => 'PNS',
    ]);

    $this->admin = User::create([
        'username' => 'admin_test',
        'email' => 'admin_sppd@example.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
        'status' => 'aktif',
    ]);

    $this->verifikator = User::create([
        'username' => 'verifikator_test',
        'email' => 'verifikator@example.com',
        'password' => bcrypt('password'),
        'role' => 'verifikator',
        'status' => 'aktif',
    ]);

    $this->tujuan = TujuanTugas::create([
        'kota_tujuan' => 'Banjarmasin',
        'provinsi_tujuan' => 'Kalimantan Selatan',
        'instansi_tujuan' => 'Diskominfo Kalsel',
        'alamat_tujuan' => 'Jl. Dharma Praja',
    ]);

    $this->spt = Spt::create([
        'nomor_spt' => '090/010/DISKOMINFO/2026',
        'pejabat_id' => $this->pejabat->id,
        'tujuan_id' => $this->tujuan->id,
        'maksud_perjalanan' => 'Konsultasi SPBE',
        'tanggal_berangkat' => '2026-10-10',
        'tanggal_kembali' => '2026-10-12',
        'lama_hari' => 3,
        'transportasi' => 'Darat',
        'status_spt' => 'disetujui',
    ]);
});

test('sppd index displays cetak button and month-year filters', function () {
    $response = $this->actingAs($this->admin)->get(route('sppd.index'));

    $response->assertStatus(200);
    $response->assertSee(route('cetak.sppd.rekap'));
    $response->assertSee('Semua Bulan');
    $response->assertSee('Semua Tahun');
});

test('sppd index filters by month and year', function () {
    Sppd::create([
        'nomor_sppd' => 'SPPD-OKT-2026',
        'spt_id' => $this->spt->id,
        'pegawai_id' => $this->pegawai->id,
        'tingkat_biaya' => 'Tingkat C',
        'alat_angkut' => 'Mobil Dinas',
        'tempat_berangkat' => 'Kuala Kapuas',
        'tempat_tujuan' => 'Banjarmasin',
        'tanggal_berangkat' => '2026-10-10',
        'tanggal_kembali' => '2026-10-12',
        'lama_hari' => 3,
        'pembebanan_anggaran' => 'APBD',
        'status_sppd' => 'diverifikasi',
    ]);

    Sppd::create([
        'nomor_sppd' => 'SPPD-NOV-2026',
        'spt_id' => $this->spt->id,
        'pegawai_id' => $this->pegawai->id,
        'tingkat_biaya' => 'Tingkat C',
        'alat_angkut' => 'Mobil Dinas',
        'tempat_berangkat' => 'Kuala Kapuas',
        'tempat_tujuan' => 'Banjarmasin',
        'tanggal_berangkat' => '2026-11-15',
        'tanggal_kembali' => '2026-11-17',
        'lama_hari' => 3,
        'pembebanan_anggaran' => 'APBD',
        'status_sppd' => 'diverifikasi',
    ]);

    $response = $this->actingAs($this->admin)->get(route('sppd.index', [
        'bulan' => '10',
        'tahun' => '2026',
    ]));

    $response->assertStatus(200);
    $response->assertSee('SPPD-OKT-2026');
    $response->assertDontSee('SPPD-NOV-2026');
});

test('cetak rekap sppd streams pdf', function () {
    Sppd::create([
        'nomor_sppd' => 'SPPD-TEST-PDF',
        'spt_id' => $this->spt->id,
        'pegawai_id' => $this->pegawai->id,
        'tingkat_biaya' => 'Tingkat C',
        'alat_angkut' => 'Mobil Dinas',
        'tempat_berangkat' => 'Kuala Kapuas',
        'tempat_tujuan' => 'Banjarmasin',
        'tanggal_berangkat' => '2026-10-10',
        'tanggal_kembali' => '2026-10-12',
        'lama_hari' => 3,
        'pembebanan_anggaran' => 'APBD',
        'status_sppd' => 'diverifikasi',
    ]);

    $response = $this->actingAs($this->admin)->get(route('cetak.sppd.rekap'));

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/pdf');
});

test('cetak rekap sppd filters by month and year in html format', function () {
    $sppd1 = Sppd::create([
        'nomor_sppd' => 'SPPD-OKT-2026',
        'spt_id' => $this->spt->id,
        'pegawai_id' => $this->pegawai->id,
        'tingkat_biaya' => 'Tingkat C',
        'alat_angkut' => 'Mobil Dinas',
        'tempat_berangkat' => 'Kuala Kapuas',
        'tempat_tujuan' => 'Banjarmasin',
        'tanggal_berangkat' => '2026-10-10',
        'tanggal_kembali' => '2026-10-12',
        'lama_hari' => 3,
        'pembebanan_anggaran' => 'APBD',
        'status_sppd' => 'diverifikasi',
    ]);

    AnggaranSppd::create([
        'sppd_id' => $sppd1->id,
        'uang_harian' => 1000000,
        'biaya_transport' => 500000,
        'biaya_penginapan' => 800000,
        'uang_representasi' => 0,
        'sewa_kendaraan' => 0,
        'biaya_lainnya' => 0,
        'total_biaya' => 2300000,
        'sumber_dana' => 'DPA SKPD',
        'kode_rekening' => '5.1.02.04',
        'tahun_anggaran' => 2026,
    ]);

    Sppd::create([
        'nomor_sppd' => 'SPPD-NOV-2026',
        'spt_id' => $this->spt->id,
        'pegawai_id' => $this->pegawai->id,
        'tingkat_biaya' => 'Tingkat C',
        'alat_angkut' => 'Mobil Dinas',
        'tempat_berangkat' => 'Kuala Kapuas',
        'tempat_tujuan' => 'Banjarmasin',
        'tanggal_berangkat' => '2026-11-15',
        'tanggal_kembali' => '2026-11-17',
        'lama_hari' => 3,
        'pembebanan_anggaran' => 'APBD',
        'status_sppd' => 'diverifikasi',
    ]);

    $response = $this->actingAs($this->admin)->get(route('cetak.sppd.rekap', [
        'format' => 'html',
        'bulan' => '10',
        'tahun' => '2026',
    ]));

    $response->assertStatus(200);
    $response->assertSee('SPPD-OKT-2026');
    $response->assertDontSee('SPPD-NOV-2026');
    $response->assertSee('Periode:');
    $response->assertSee('Bulan Oktober');
    $response->assertSee('Tahun 2026');
    $response->assertSee('2.300.000');
});
test('verifikasi index displays cetak button and filters by month and year', function () {
    Sppd::create([
        'nomor_sppd' => 'SPPD-VERIF-OKT',
        'spt_id' => $this->spt->id,
        'pegawai_id' => $this->pegawai->id,
        'tingkat_biaya' => 'Tingkat C',
        'alat_angkut' => 'Mobil Dinas',
        'tempat_berangkat' => 'Kuala Kapuas',
        'tempat_tujuan' => 'Banjarmasin',
        'tanggal_berangkat' => '2026-10-10',
        'tanggal_kembali' => '2026-10-12',
        'lama_hari' => 3,
        'pembebanan_anggaran' => 'APBD',
        'status_sppd' => 'menunggu_verifikasi',
    ]);

    Sppd::create([
        'nomor_sppd' => 'SPPD-VERIF-NOV',
        'spt_id' => $this->spt->id,
        'pegawai_id' => $this->pegawai->id,
        'tingkat_biaya' => 'Tingkat C',
        'alat_angkut' => 'Mobil Dinas',
        'tempat_berangkat' => 'Kuala Kapuas',
        'tempat_tujuan' => 'Banjarmasin',
        'tanggal_berangkat' => '2026-11-10',
        'tanggal_kembali' => '2026-11-12',
        'lama_hari' => 3,
        'pembebanan_anggaran' => 'APBD',
        'status_sppd' => 'menunggu_verifikasi',
    ]);

    $response = $this->actingAs($this->verifikator)->get(route('verifikasi.index', [
        'bulan' => '10',
        'tahun' => '2026',
    ]));

    $response->assertStatus(200);
    $response->assertSee(route('cetak.verifikasi.rekap'));
    $response->assertSee('SPPD-VERIF-OKT');
    $response->assertDontSee('SPPD-VERIF-NOV');
});

test('cetak rekap verifikasi streams pdf and supports html format', function () {
    $sppd = Sppd::create([
        'nomor_sppd' => 'SPPD-VERIF-OKT-2',
        'spt_id' => $this->spt->id,
        'pegawai_id' => $this->pegawai->id,
        'tingkat_biaya' => 'Tingkat C',
        'alat_angkut' => 'Mobil Dinas',
        'tempat_berangkat' => 'Kuala Kapuas',
        'tempat_tujuan' => 'Banjarmasin',
        'tanggal_berangkat' => '2026-10-10',
        'tanggal_kembali' => '2026-10-12',
        'lama_hari' => 3,
        'pembebanan_anggaran' => 'APBD',
        'status_sppd' => 'diverifikasi',
    ]);

    VerifikasiSppd::create([
        'sppd_id' => $sppd->id,
        'verifikator_id' => $this->verifikator->id,
        'tanggal_verifikasi' => now(),
        'status_verifikasi' => 'disetujui',
        'catatan' => 'Berkas lengkap dan sesuai',
    ]);

    $pdfResponse = $this->actingAs($this->verifikator)->get(route('cetak.verifikasi.rekap'));
    $pdfResponse->assertStatus(200);
    $pdfResponse->assertHeader('content-type', 'application/pdf');

    $htmlResponse = $this->actingAs($this->verifikator)->get(route('cetak.verifikasi.rekap', [
        'format' => 'html',
        'bulan' => '10',
        'tahun' => '2026',
    ]));
    $htmlResponse->assertStatus(200);
    $htmlResponse->assertSee('SPPD-VERIF-OKT-2');
    $htmlResponse->assertSee('Berkas lengkap dan sesuai');
    $htmlResponse->assertSee('Periode:');
    $htmlResponse->assertSee('Bulan Oktober');
    $htmlResponse->assertSee('Tahun 2026');
});
