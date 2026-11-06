<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kuitansi SPPD - {{ $sppd->nomor_sppd }}</title>
    <style>
        @page {
            size: 215mm 330mm;
            margin: 1.2cm 1.5cm 1.5cm 1.5cm;
        }
        body { font-family: 'Times New Roman', serif; font-size: 10.5pt; margin: 0; padding: 0; line-height: 1.2; }
        .kop { border-bottom: 3px double #000; padding-bottom: 8px; margin-bottom: 12px; }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-table td { vertical-align: middle; padding: 0; border: none; }
        .kop-logo-kiri { width: 15%; text-align: left; }
        .kop-logo-kanan { width: 15%; text-align: right; }
        .kop-logo-kiri img { width: 65px; height: auto; }
        .kop-logo-kanan img { width: 105px; height: 60px; }
        .kop-text { width: 70%; text-align: center; }
        .kop h3 { margin: 0; font-size: 11pt; }
        .kop h1 { margin: 2px 0; font-size: 15pt; }
        .kop h2 { margin: 2px 0; font-size: 13pt; }
        .kop p { margin: 0; font-size: 8.5pt; }
        .title { text-align: center; margin: 15px 0 10px; }
        .title h2 { margin: 0; font-size: 14pt; text-decoration: underline; }
        table.info { width: 100%; margin-top: 8px; }
        table.info td { padding: 3px 5px; font-size: 10.5pt; vertical-align: top; }
        table.rincian { width: 100%; border-collapse: collapse; margin-top: 8px; }
        table.rincian th, table.rincian td { border: 1px solid #000; padding: 4px 6px; font-size: 10pt; }
        table.rincian th { background: #f0f0f0; text-align: center; }
        table.rincian .right { text-align: right; }
        .total-row { font-weight: bold; background: #e8f4f8; }
        .terbilang { margin-top: 8px; padding: 6px 12px; border: 1px solid #000; font-style: italic; font-size: 10pt; }
        .ttd-container { margin-top: 20px; }
        .ttd-table { width: 100%; }
        .ttd-table td { text-align: center; vertical-align: top; padding: 3px; }
        .nama-ttd { margin-top: 50px; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="kop">
        <table class="kop-table">
            <tr>
                <td class="kop-logo-kiri">
                    <img src="{{ public_path('logo/kiri.webp') }}" alt="Logo Kabupaten Kapuas">
                </td>
                <td class="kop-text">
                    <h3>PEMERINTAH KABUPATEN KAPUAS</h3>
                    <h1>DINAS KOMUNIKASI, INFORMATIKA,</h1>
                    <h2>STATISTIK DAN PERSANDIAN</h2>
                    <p>Jl. Pemuda No. 1 Kuala Kapuas, Kalimantan Tengah 73514</p>
                    <p>Telp. (0513) 21234 | Email: diskominfosantik@kapuaskab.go.id</p>
                </td>
                <td class="kop-logo-kanan">
                    <img src="{{ public_path('logo/kanan.webp') }}" alt="Logo Diskominfosantik">
                </td>
            </tr>
        </table>
    </div>

    <div class="title">
        <h2>KUITANSI / BUKTI PEMBAYARAN</h2>
    </div>

    <table class="info">
        <tr><td width="25%">Nomor SPPD</td><td width="3%">:</td><td>{{ $sppd->nomor_sppd }}</td></tr>
        <tr><td>Nomor SPT</td><td>:</td><td>{{ $sppd->spt->nomor_spt ?? '-' }}</td></tr>
        <tr><td>Telah diterima dari</td><td>:</td><td>Bendahara Pengeluaran DISKOMINFOSANTIK Kab. Kapuas</td></tr>
        <tr><td>Nama Penerima</td><td>:</td><td>{{ $sppd->pegawai->nama_pegawai ?? '-' }}</td></tr>
        <tr><td>NIP</td><td>:</td><td>{{ $sppd->pegawai->nip ?? '-' }}</td></tr>
        <tr><td>Jabatan</td><td>:</td><td>{{ $sppd->pegawai->jabatan ?? '-' }}</td></tr>
        <tr><td>Untuk Keperluan</td><td>:</td><td>Biaya Perjalanan Dinas ke {{ $sppd->tempat_tujuan }}<br>{{ $sppd->spt->maksud_perjalanan ?? '' }}</td></tr>
    </table>

    @if($sppd->anggaran)
    <table class="rincian">
        <thead>
            <tr><th>No</th><th>Uraian</th><th>Jumlah (Rp)</th></tr>
        </thead>
        <tbody>
            <tr><td style="text-align:center;">1</td><td>Uang Harian</td><td class="right">{{ number_format($sppd->anggaran->uang_harian, 0, ',', '.') }}</td></tr>
            <tr><td style="text-align:center;">2</td><td>Biaya Transportasi</td><td class="right">{{ number_format($sppd->anggaran->biaya_transportasi, 0, ',', '.') }}</td></tr>
            <tr><td style="text-align:center;">3</td><td>Biaya Penginapan</td><td class="right">{{ number_format($sppd->anggaran->biaya_penginapan, 0, ',', '.') }}</td></tr>
            <tr><td style="text-align:center;">4</td><td>Biaya Taksi / Transport Lokal</td><td class="right">{{ number_format($sppd->anggaran->biaya_taksi, 0, ',', '.') }}</td></tr>
            <tr><td style="text-align:center;">5</td><td>Biaya Representasi</td><td class="right">{{ number_format($sppd->anggaran->biaya_representasi, 0, ',', '.') }}</td></tr>
            <tr><td style="text-align:center;">6</td><td>Biaya Lainnya</td><td class="right">{{ number_format($sppd->anggaran->biaya_lainnya, 0, ',', '.') }}</td></tr>
            <tr class="total-row"><td colspan="2" style="text-align:center;">JUMLAH TOTAL</td><td class="right">{{ number_format($sppd->anggaran->total_biaya, 0, ',', '.') }}</td></tr>
        </tbody>
    </table>

    <div class="terbilang">
        <strong>Terbilang:</strong> {{ $terbilang }}
    </div>

    <p style="margin-top:10px; font-size:10pt;">Sumber Dana: {{ $sppd->anggaran->sumber_dana }} | Kode Rekening: {{ $sppd->anggaran->kode_rekening }} | Tahun Anggaran: {{ $sppd->anggaran->tahun_anggaran }}</p>
    @endif

    <div class="ttd-container">
        <table class="ttd-table">
            <tr>
                <td width="33%">
                    <p>Mengetahui/Menyetujui</p>
                    <p>{{ $sppd->spt->pejabat->jabatan ?? 'Kepala Dinas' }}</p>
                    <p class="nama-ttd">{{ $sppd->spt->pejabat->nama_pegawai ?? '-' }}</p>
                    <p>NIP. {{ $sppd->spt->pejabat->nip ?? '-' }}</p>
                </td>
                <td width="33%">
                    <p>Bendahara Pengeluaran</p>
                    <p>&nbsp;</p>
                    <p class="nama-ttd">(...................................)</p>
                    <p>NIP.</p>
                </td>
                <td width="33%">
                    <p>Kuala Kapuas, {{ now()->translatedFormat('d F Y') }}</p>
                    <p>Yang Menerima</p>
                    <p class="nama-ttd">{{ $sppd->pegawai->nama_pegawai ?? '-' }}</p>
                    <p>NIP. {{ $sppd->pegawai->nip ?? '-' }}</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
