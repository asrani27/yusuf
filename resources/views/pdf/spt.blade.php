<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>SPT - {{ $spt->nomor_spt }}</title>
    <style>
        @page {
            size: 215mm 330mm;
            margin: 1.2cm 1.5cm 1.5cm 1.5cm;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 10.5pt;
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        .kop {
            border-bottom: 3px double #000;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-table td {
            vertical-align: middle;
            padding: 0;
        }

        .kop-logo-kiri {
            width: 15%;
            text-align: left;
        }

        .kop-logo-kanan {
            width: 15%;
            text-align: right;
        }

        .kop-logo-kiri img {
            width: 65px;
            height: auto;
        }

        .kop-logo-kanan img {
            width: 105px;
            height: 60px;
        }

        .kop-text {
            width: 70%;
            text-align: center;
        }

        .kop h3 {
            margin: 0;
            font-size: 12pt;
            letter-spacing: 1px;
        }

        .kop h2 {
            margin: 2px 0;
            font-size: 14pt;
            letter-spacing: 2px;
        }

        .kop h1 {
            margin: 2px 0;
            font-size: 15pt;
            letter-spacing: 1.5px;
        }

        .kop p {
            margin: 0;
            font-size: 9pt;
        }

        .title {
            text-align: center;
            margin: 15px 0 5px;
        }

        .title h2 {
            margin: 0;
            font-size: 13pt;
            text-decoration: underline;
        }

        .title p {
            margin: 2px 0;
            font-size: 10pt;
        }

        table.info {
            width: 100%;
            margin-top: 10px;
        }

        table.info td {
            vertical-align: top;
            padding: 2px 5px;
            font-size: 10.5pt;
        }

        table.pegawai {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        table.pegawai th,
        table.pegawai td {
            border: 1px solid #000;
            padding: 4px 6px;
            font-size: 10pt;
        }

        table.pegawai th {
            background: #f0f0f0;
            text-align: center;
        }

        .ttd {
            margin-top: 25px;
            text-align: right;
            padding-right: 40px;
        }

        .ttd .nama {
            margin-top: 50px;
            font-weight: bold;
            text-decoration: underline;
        }

        .ttd .nip {
            margin-top: 2px;
            font-size: 10pt;
        }
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
        <h2>SURAT PERINTAH TUGAS</h2>
        <p>Nomor: {{ $spt->nomor_spt }}</p>
    </div>

    <table class="info">
        @if($spt->dasar_penugasan)
        <tr>
            <td width="5%"></td>
            <td width="3%"></td>
            <td colspan="2"><strong>Dasar:</strong></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td colspan="2">{{ $spt->dasar_penugasan }}</td>
        </tr>
        @endif
    </table>

    <p style="margin-top:15px;">Yang bertanda tangan di bawah ini:</p>
    <table class="info">
        <tr>
            <td width="30%">Nama</td>
            <td width="3%">:</td>
            <td>{{ $spt->pejabat->nama_pegawai ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIP</td>
            <td>:</td>
            <td>{{ $spt->pejabat->nip ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $spt->pejabat->jabatan ?? '-' }}</td>
        </tr>
    </table>

    <p style="margin-top:10px;">Dengan ini memerintahkan kepada:</p>

    <table class="pegawai">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama / NIP</th>
                <th>Pangkat/Gol</th>
                <th>Jabatan</th>
                <th>Peran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($spt->pengikut as $i => $p)
            <tr>
                <td style="text-align:center;">{{ $i + 1 }}</td>
                <td>{{ $p->nama_pegawai }}<br><small>NIP. {{ $p->nip }}</small></td>
                <td>{{ $p->pangkat_golongan }}</td>
                <td>{{ $p->jabatan }}</td>
                <td style="text-align:center;">{{ $p->pivot->peran_tugas }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top:15px;">Untuk:</p>
    <table class="info">
        <tr>
            <td width="30%">Maksud Perjalanan</td>
            <td width="3%">:</td>
            <td>{{ $spt->maksud_perjalanan }}</td>
        </tr>
        <tr>
            <td>Tujuan</td>
            <td>:</td>
            <td>{{ $spt->tujuan->kota_tujuan ?? '-' }}, {{ $spt->tujuan->provinsi_tujuan ?? '' }} ({{
                $spt->tujuan->instansi_tujuan ?? '' }})</td>
        </tr>
        <tr>
            <td>Transportasi</td>
            <td>:</td>
            <td>{{ $spt->transportasi }}</td>
        </tr>
        <tr>
            <td>Tanggal Berangkat</td>
            <td>:</td>
            <td>{{ $spt->tanggal_berangkat->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Tanggal Kembali</td>
            <td>:</td>
            <td>{{ $spt->tanggal_kembali->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Lama Perjalanan</td>
            <td>:</td>
            <td>{{ $spt->lama_hari }} ({{ \App\Helpers\Terbilang::convert($spt->lama_hari) }}) hari</td>
        </tr>
    </table>

    <p style="margin-top:10px;">Demikian Surat Perintah Tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab.
    </p>

    <div class="ttd">
        <p>Kuala Kapuas, {{ $spt->created_at->translatedFormat('d F Y') }}</p>
        <p>{{ $spt->pejabat->jabatan ?? 'Kepala Dinas' }}</p>
        <p class="nama">{{ $spt->pejabat->nama_pegawai ?? '-' }}</p>
        <p class="nip">NIP. {{ $spt->pejabat->nip ?? '-' }}</p>
    </div>
</body>

</html>