<?php

use App\Models\Pegawai;
use App\Models\Spt;
use App\Models\TujuanTugas;
use App\Models\User;
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

    $this->user = User::create([
        'username' => 'admin_test',
        'email' => 'admin_test@example.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
        'status' => 'aktif',
    ]);

    $this->tujuan = TujuanTugas::create([
        'kota_tujuan' => 'Palangka Raya',
        'provinsi_tujuan' => 'Kalimantan Tengah',
        'instansi_tujuan' => 'Diskominfo Kalteng',
        'alamat_tujuan' => 'Jl. Tjilik Riwut',
    ]);
});

test('spt index displays cetak button', function () {
    $response = $this->actingAs($this->user)->get(route('spt.index'));

    $response->assertStatus(200);
    $response->assertSee(route('cetak.spt.rekap'));
    $response->assertSee('Cetak');
    $response->assertSee('Semua Bulan');
    $response->assertSee('Semua Tahun');
});

test('spt index filters by month and year', function () {
    Spt::create([
        'nomor_spt' => 'SPT-OKT-2026',
        'pejabat_id' => $this->pejabat->id,
        'tujuan_id' => $this->tujuan->id,
        'maksud_perjalanan' => 'Tugas Oktober',
        'tanggal_berangkat' => '2026-10-15',
        'tanggal_kembali' => '2026-10-18',
        'lama_hari' => 4,
        'transportasi' => 'Darat',
        'status_spt' => 'disetujui',
    ]);

    Spt::create([
        'nomor_spt' => 'SPT-NOV-2026',
        'pejabat_id' => $this->pejabat->id,
        'tujuan_id' => $this->tujuan->id,
        'maksud_perjalanan' => 'Tugas November',
        'tanggal_berangkat' => '2026-11-10',
        'tanggal_kembali' => '2026-11-12',
        'lama_hari' => 3,
        'transportasi' => 'Darat',
        'status_spt' => 'disetujui',
    ]);

    $response = $this->actingAs($this->user)->get(route('spt.index', [
        'bulan' => '10',
        'tahun' => '2026',
    ]));

    $response->assertStatus(200);
    $response->assertSee('SPT-OKT-2026');
    $response->assertDontSee('SPT-NOV-2026');
});

test('authenticated user can stream cetak rekap spt pdf', function () {
    Spt::create([
        'nomor_spt' => '090/001/DISKOMINFO/2026',
        'pejabat_id' => $this->pejabat->id,
        'tujuan_id' => $this->tujuan->id,
        'maksud_perjalanan' => 'Koordinasi jaringan internet',
        'tanggal_berangkat' => '2026-11-01',
        'tanggal_kembali' => '2026-11-03',
        'lama_hari' => 3,
        'transportasi' => 'Darat',
        'status_spt' => 'disetujui',
    ]);

    $response = $this->actingAs($this->user)->get(route('cetak.spt.rekap'));

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/pdf');
});

test('cetak rekap spt supports html format and filters by status', function () {
    Spt::create([
        'nomor_spt' => 'SPT-DISETUJUI-001',
        'pejabat_id' => $this->pejabat->id,
        'tujuan_id' => $this->tujuan->id,
        'maksud_perjalanan' => 'Tugas Disetujui',
        'tanggal_berangkat' => '2026-11-01',
        'tanggal_kembali' => '2026-11-03',
        'lama_hari' => 3,
        'transportasi' => 'Darat',
        'status_spt' => 'disetujui',
    ]);

    Spt::create([
        'nomor_spt' => 'SPT-DRAFT-002',
        'pejabat_id' => $this->pejabat->id,
        'tujuan_id' => $this->tujuan->id,
        'maksud_perjalanan' => 'Tugas Draft',
        'tanggal_berangkat' => '2026-11-05',
        'tanggal_kembali' => '2026-11-07',
        'lama_hari' => 3,
        'transportasi' => 'Darat',
        'status_spt' => 'draft',
    ]);

    $response = $this->actingAs($this->user)->get(route('cetak.spt.rekap', [
        'format' => 'html',
        'status' => 'disetujui',
    ]));

    $response->assertStatus(200);
    $response->assertSee('SPT-DISETUJUI-001');
    $response->assertDontSee('SPT-DRAFT-002');
    $response->assertSee('Palangka Raya');
    $response->assertSee('Disetujui');
});

test('cetak rekap spt filters by month and year and displays period in html', function () {
    Spt::create([
        'nomor_spt' => 'SPT-OKT-2026',
        'pejabat_id' => $this->pejabat->id,
        'tujuan_id' => $this->tujuan->id,
        'maksud_perjalanan' => 'Tugas Oktober',
        'tanggal_berangkat' => '2026-10-15',
        'tanggal_kembali' => '2026-10-18',
        'lama_hari' => 4,
        'transportasi' => 'Darat',
        'status_spt' => 'disetujui',
    ]);

    Spt::create([
        'nomor_spt' => 'SPT-NOV-2026',
        'pejabat_id' => $this->pejabat->id,
        'tujuan_id' => $this->tujuan->id,
        'maksud_perjalanan' => 'Tugas November',
        'tanggal_berangkat' => '2026-11-10',
        'tanggal_kembali' => '2026-11-12',
        'lama_hari' => 3,
        'transportasi' => 'Darat',
        'status_spt' => 'disetujui',
    ]);

    $response = $this->actingAs($this->user)->get(route('cetak.spt.rekap', [
        'format' => 'html',
        'bulan' => '10',
        'tahun' => '2026',
    ]));

    $response->assertStatus(200);
    $response->assertSee('SPT-OKT-2026');
    $response->assertDontSee('SPT-NOV-2026');
    $response->assertSee('Periode:');
    $response->assertSee('Bulan Oktober');
    $response->assertSee('Tahun 2026');
});

test('cetak rekap spt requires authentication', function () {
    $response = $this->get(route('cetak.spt.rekap'));

    $response->assertRedirect(route('login'));
});
