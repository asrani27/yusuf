<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SPPD - {{ $sppd->nomor_sppd }}</title>
    <style>
        @page {
            size: 215mm 330mm;
            margin: 1.2cm 1.5cm 1.5cm 1.5cm;
        }
        body { font-family: 'Times New Roman', serif; font-size: 10.5pt; margin: 0; padding: 0; line-height: 1.2; }
        .kop { border-bottom: 3px double #000; padding-bottom: 6px; margin-bottom: 8px; }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-table td { vertical-align: middle; padding: 0; border: none; }
        .kop-logo-kiri { width: 15%; text-align: left; }
        .kop-logo-kanan { width: 15%; text-align: right; }
        .kop-logo-kiri img { width: 65px; height: auto; }
        .kop-logo-kanan img { width: 105px; height: 60px; }
        .kop-text { width: 70%; text-align: center; }
        .kop h3 { margin: 0; font-size: 11pt; }
        .kop h1 { margin: 2px 0; font-size: 14pt; }
        .kop h2 { margin: 2px 0; font-size: 12pt; }
        .kop p { margin: 0; font-size: 8.5pt; }
        .title { text-align: center; margin: 10px 0 8px; }
        .title h2 { margin: 0; font-size: 12pt; text-decoration: underline; }
        .title p { margin: 2px 0; font-size: 9.5pt; }
        table.form { width: 100%; border-collapse: collapse; table-layout: fixed; }
        table.form td { padding: 3px 5px; font-size: 10.5pt; vertical-align: top; border: 1px solid #000; word-wrap: break-word; overflow-wrap: break-word; }
        table.form td.no-border { border: none; }
        table.belakang { width: 100%; border-collapse: collapse; table-layout: fixed; }
        table.belakang td { padding: 6px 8px; font-size: 10pt; vertical-align: top; border: 1px solid #000; text-align: center; word-wrap: break-word; overflow-wrap: break-word; line-height: 1.3; }
        table.belakang .col-kiri { width: 50%; }
        table.belakang .col-kanan { width: 50%; }
        table.belakang .header-cell { font-weight: bold; padding: 5px 8px; }
        table.belakang .ttd-cell { padding: 8px 10px; }
        table.belakang .ttd-cell p { margin: 2px 0; }
        table.belakang .ttd-cell .spasi-ttd { height: 40px; }
        table.belakang .ttd-cell .nama-pejabat { font-weight: bold; text-decoration: underline; }
        .page-break { page-break-before: always; }
        .ttd { margin-top: 15px; }
        .ttd-table { width: 100%; }
        .ttd-table td { text-align: center; vertical-align: top; padding: 3px; }
        .nama-ttd { margin-top: 45px; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>
    {{-- LEMBAR DEPAN --}}
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
                </td>
                <td class="kop-logo-kanan">
                    <img src="{{ public_path('logo/kanan.webp') }}" alt="Logo Diskominfosantik">
                </td>
            </tr>
        </table>
    </div>

    <div class="title">
        <h2>SURAT PERINTAH PERJALANAN DINAS (SPPD)</h2>
        <p>Nomor: {{ $sppd->nomor_sppd }}</p>
    </div>

    <table class="form">
        <tr><td width="5%">1</td><td width="35%">Pejabat berwenang yang memberi perintah</td><td>{{ $sppd->spt->pejabat->nama_pegawai ?? '-' }} - {{ $sppd->spt->pejabat->jabatan ?? '' }}</td></tr>
        <tr><td>2</td><td>Nama / NIP pegawai yang diperintahkan</td><td>{{ $sppd->pegawai->nama_pegawai ?? '-' }}<br>NIP. {{ $sppd->pegawai->nip ?? '-' }}</td></tr>
        <tr><td>3</td><td>a. Pangkat dan Golongan<br>b. Jabatan<br>c. Tingkat biaya perjalanan dinas</td><td>a. {{ $sppd->pegawai->pangkat_golongan ?? '-' }}<br>b. {{ $sppd->pegawai->jabatan ?? '-' }}<br>c. {{ $sppd->tingkat_biaya ?? '-' }}</td></tr>
        <tr><td>4</td><td>Maksud Perjalanan Dinas</td><td>{{ $sppd->spt->maksud_perjalanan ?? '-' }}</td></tr>
        <tr><td>5</td><td>Alat angkutan yang dipergunakan</td><td>{{ $sppd->alat_angkut }}</td></tr>
        <tr><td>6</td><td>a. Tempat berangkat<br>b. Tempat tujuan</td><td>a. {{ $sppd->tempat_berangkat }}<br>b. {{ $sppd->tempat_tujuan }}</td></tr>
        <tr><td>7</td><td>a. Lamanya perjalanan dinas<br>b. Tanggal berangkat<br>c. Tanggal harus kembali</td><td>a. {{ $sppd->lama_hari }} ({{ \App\Helpers\Terbilang::convert($sppd->lama_hari) }}) hari<br>b. {{ $sppd->tanggal_berangkat->translatedFormat('d F Y') }}<br>c. {{ $sppd->tanggal_kembali->translatedFormat('d F Y') }}</td></tr>
        <tr><td>8</td><td>Pengikut: Nama, Tanggal lahir, Keterangan</td><td>-</td></tr>
        <tr><td>9</td><td>Pembebanan Anggaran<br>a. Instansi<br>b. Mata Anggaran / MAK</td><td><br>a. {{ $sppd->pembebanan_anggaran }}<br>b. {{ $sppd->anggaran->kode_rekening ?? '-' }}</td></tr>
        <tr><td>10</td><td>Keterangan lain-lain</td><td>{{ $sppd->keterangan ?? '-' }}</td></tr>
    </table>

    <table class="ttd-table" style="margin-top:20px;">
        <tr>
            <td width="50%">
                <p>Dikeluarkan di: Kuala Kapuas</p>
                <p>Pada tanggal: {{ $sppd->created_at->translatedFormat('d F Y') }}</p>
                <p style="margin-top:5px;">{{ $sppd->spt->pejabat->jabatan ?? 'Kepala Dinas' }}</p>
                <p class="nama-ttd">{{ $sppd->spt->pejabat->nama_pegawai ?? '-' }}</p>
                <p>NIP. {{ $sppd->spt->pejabat->nip ?? '-' }}</p>
            </td>
            <td width="50%"></td>
        </tr>
    </table>

    {{-- LEMBAR BELAKANG --}}
    <div class="page-break"></div>

    <div style="text-align:center; margin-bottom:15px;">
        <h3 style="text-decoration:underline;">LEMBAR BELAKANG SPPD</h3>
        <p>Nomor: {{ $sppd->nomor_sppd }}</p>
    </div>

    <table class="belakang">
        <colgroup>
            <col style="width: 50%;">
            <col style="width: 50%;">
        </colgroup>
        {{-- Baris I: Header Berangkat --}}
        <tr>
            <td class="header-cell">I. Berangkat dari: {{ $sppd->tempat_berangkat }}</td>
            <td class="header-cell">Ke: {{ $sppd->tempat_tujuan }}</td>
        </tr>
        {{-- Baris I: TTD Berangkat --}}
        <tr>
            <td class="ttd-cell">
                <p>Pada tanggal: {{ $sppd->tanggal_berangkat->translatedFormat('d F Y') }}</p>
            </td>
            <td class="ttd-cell">
                <p>{{ $sppd->spt->pejabat->jabatan ?? 'Kepala Dinas' }}</p>
                <div class="spasi-ttd"></div>
                <p class="nama-pejabat">{{ $sppd->spt->pejabat->nama_pegawai ?? '-' }}</p>
                <p>NIP. {{ $sppd->spt->pejabat->nip ?? '-' }}</p>
            </td>
        </tr>
        {{-- Baris II: Header Tiba & Berangkat dari tujuan --}}
        <tr>
            <td class="header-cell">II. Tiba di: {{ $sppd->tempat_tujuan }}</td>
            <td class="header-cell">Berangkat dari: {{ $sppd->tempat_tujuan }}</td>
        </tr>
        {{-- Baris II: TTD Tiba & Berangkat --}}
        <tr>
            <td class="ttd-cell">
                <p>Pada tanggal: {{ $sppd->tanggal_berangkat->translatedFormat('d F Y') }}</p>
                <p style="margin-top: 5px;">Mengetahui/Mengesahkan</p>
                <div class="spasi-ttd"></div>
                <p>(............................)</p>
                <p>NIP.</p>
            </td>
            <td class="ttd-cell">
                <p>Ke: {{ $sppd->tempat_berangkat }}</p>
                <p>Pada tanggal: {{ $sppd->tanggal_kembali->translatedFormat('d F Y') }}</p>
                <div class="spasi-ttd"></div>
                <p>(............................)</p>
                <p>NIP.</p>
            </td>
        </tr>
        {{-- Baris III: Header Tiba kembali --}}
        <tr>
            <td class="header-cell">III. Tiba di: {{ $sppd->tempat_berangkat }}</td>
            <td class="header-cell">&nbsp;</td>
        </tr>
        {{-- Baris III: TTD Tiba kembali & Verifikasi --}}
        <tr>
            <td class="ttd-cell">
                <p>Pada tanggal: {{ $sppd->tanggal_kembali->translatedFormat('d F Y') }}</p>
                <p style="margin-top: 5px;">Mengetahui/Mengesahkan</p>
                <p>{{ $sppd->spt->pejabat->jabatan ?? 'Kepala Dinas' }}</p>
                <div class="spasi-ttd"></div>
                <p class="nama-pejabat">{{ $sppd->spt->pejabat->nama_pegawai ?? '-' }}</p>
                <p>NIP. {{ $sppd->spt->pejabat->nip ?? '-' }}</p>
            </td>
            <td class="ttd-cell">
                <p>Telah diperiksa dengan keterangan bahwa perjalanan tersebut di atas benar dilakukan atas perintah dan semata-mata untuk kepentingan jabatan dalam waktu yang sesingkat-singkatnya.</p>
                <p style="margin-top: 5px;">{{ $sppd->spt->pejabat->jabatan ?? 'Kepala Dinas' }}</p>
                <div class="spasi-ttd"></div>
                <p class="nama-pejabat">{{ $sppd->spt->pejabat->nama_pegawai ?? '-' }}</p>
                <p>NIP. {{ $sppd->spt->pejabat->nip ?? '-' }}</p>
            </td>
        </tr>
    </table>

    <p style="margin-top:10px; font-size:9pt;">Catatan: Pada setiap tempat kedatangan/keberangkatan, pejabat yang berwenang <em>wajib</em> membubuhkan tanda tangan, nama jelas, cap jabatan, tanggal kedatangan/keberangkatan.</p>
</body>
</html>
