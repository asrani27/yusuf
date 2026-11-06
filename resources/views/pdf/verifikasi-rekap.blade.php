<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Daftar Laporan Verifikasi SPPD</title>
    <style>
        @page {
            size: 330mm 215mm;
            margin: 1.2cm 1.5cm 1.5cm 1.5cm;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 10pt;
            margin: 0;
            padding: 0;
            line-height: 1.3;
            color: #000;
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
            border: none;
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
            width: 155px;
            height: 60px;
        }

        .kop-text {
            width: 70%;
            text-align: center;
        }

        .kop h3 {
            margin: 0;
            font-size: 11pt;
            font-weight: normal;
            letter-spacing: 1px;
        }

        .kop h1 {
            margin: 2px 0;
            font-size: 14pt;
            letter-spacing: 1.5px;
        }

        .kop h2 {
            margin: 2px 0;
            font-size: 12pt;
            letter-spacing: 1.5px;
        }

        .kop p {
            margin: 0;
            font-size: 8.5pt;
        }

        .title {
            text-align: center;
            margin: 10px 0 14px;
        }

        .title h2 {
            margin: 0;
            font-size: 12pt;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .title p {
            margin: 4px 0 0;
            font-size: 9pt;
            color: #444;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 5px 6px;
            font-size: 9pt;
            vertical-align: top;
        }

        table.data th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .status-badge {
            display: inline-block;
            padding: 1px 5px;
            border-radius: 3px;
            font-size: 8pt;
            font-weight: bold;
        }

        .status-menunggu_verifikasi {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-diverifikasi {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-ditolak {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-selesai {
            background-color: #d1fae5;
            color: #065f46;
        }

        .summary {
            margin-top: 10px;
            font-size: 9.5pt;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        .ttd-table td {
            border: none;
            padding: 2px;
            font-size: 10pt;
        }

        .spasi-ttd {
            height: 50px;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    @if(request('format') === 'html')
    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <button onclick="window.print()"
            style="padding: 8px 16px; background-color: #16a34a; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: bold;">
            Cetak Dokumen
        </button>
    </div>
    @endif

    <div class="kop">
        <table class="kop-table">
            <tr>
                <td class="kop-logo-kiri">
                    <img src="{{ request('format') === 'html' ? asset('logo/kiri.webp') : public_path('logo/kiri.webp') }}"
                        alt="Logo Kabupaten Kapuas">
                </td>
                <td class="kop-text">
                    <h3>PEMERINTAH KABUPATEN KAPUAS</h3>
                    <h1>DINAS KOMUNIKASI, INFORMATIKA,</h1>
                    <h2>STATISTIK DAN PERSANDIAN</h2>
                    <p>Jl. Pemuda No. 1 Kuala Kapuas, Kalimantan Tengah 73514</p>
                    <p>Telp. (0513) 21234 | Email: diskominfosantik@kapuaskab.go.id</p>
                </td>
                <td class="kop-logo-kanan">
                    <img src="{{ request('format') === 'html' ? asset('logo/kanan.webp') : public_path('logo/kanan.webp') }}"
                        alt="Logo Diskominfosantik">
                </td>
            </tr>
        </table>
    </div>

    @php
    $daftarBulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    @endphp

    <div class="title">
        <h2>DAFTAR LAPORAN VERIFIKASI SPPD</h2>
        @if(request('bulan') || request('tahun'))
        <p style="font-size: 10pt; font-weight: bold; margin: 3px 0 0;">
            Periode:
            @if(request('bulan')) Bulan {{ $daftarBulan[(int)request('bulan')] ?? request('bulan') }} @endif
            @if(request('tahun')) Tahun {{ request('tahun') }} @endif
        </p>
        @endif
        @if(request('status') || request('search'))
        <p>
            @if(request('status')) Filter Status: <strong>{{ ucfirst(str_replace('_', ' ', request('status')))
                }}</strong> @endif
            @if(request('status') && request('search')) | @endif
            @if(request('search')) Pencarian: <strong>"{{ request('search') }}"</strong> @endif
        </p>
        @endif
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 18%;">Nomor SPPD</th>
                <th style="width: 20%;">Pegawai</th>
                <th style="width: 18%;">Nomor SPT</th>
                <th style="width: 10%;">Tgl Berangkat</th>
                <th style="width: 12%;">Status</th>
                <th style="width: 18%;">Verifikator / Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sppdList as $i => $sppd)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td><strong>{{ $sppd->nomor_sppd }}</strong></td>
                <td>
                    <strong>{{ $sppd->pegawai->nama_pegawai ?? '-' }}</strong>
                    @if(optional($sppd->pegawai)->nip)
                    <div style="font-size: 8pt; color: #555;">NIP. {{ $sppd->pegawai->nip }}</div>
                    @endif
                </td>
                <td>{{ $sppd->spt->nomor_spt ?? '-' }}</td>
                <td class="text-center">{{ $sppd->tanggal_berangkat ? $sppd->tanggal_berangkat->format('d/m/Y') : '-' }}
                </td>
                <td class="text-center">
                    <span class="status-badge status-{{ $sppd->status_sppd }}">
                        {{ ucfirst(str_replace('_', ' ', $sppd->status_sppd)) }}
                    </span>
                </td>
                <td>
                    @if($sppd->latestVerifikasi)
                    <div style="font-size: 8.5pt;">
                        <strong>{{ $sppd->latestVerifikasi->verifikator->username ?? 'Verifikator' }}</strong>
                        ({{ $sppd->latestVerifikasi->tanggal_verifikasi ?
                        \Carbon\Carbon::parse($sppd->latestVerifikasi->tanggal_verifikasi)->format('d/m/Y') : '-' }})
                    </div>
                    @if($sppd->latestVerifikasi->catatan)
                    <div style="font-size: 8pt; color: #555; margin-top: 2px;">"{{ $sppd->latestVerifikasi->catatan }}"
                    </div>
                    @endif
                    @else
                    <span style="color: #888; font-style: italic; font-size: 8pt;">Belum diverifikasi</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 15px; color: #777;">Belum ada data verifikasi SPPD
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        Total Data: <strong>{{ $sppdList->count() }}</strong> SPPD
    </div>

    <table class="ttd-table">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%; text-align: center;">
                <p style="margin: 0;">Kuala Kapuas, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
                </p>
                <p style="margin: 2px 0 0;">{{ $pejabat->jabatan ?? 'Kepala Dinas' }}</p>
                <div class="spasi-ttd"></div>
                <p style="margin: 0; font-weight: bold; text-decoration: underline;">{{ $pejabat->nama_pegawai ??
                    '.........................................' }}</p>
                <p style="margin: 2px 0 0; font-size: 9pt;">NIP. {{ $pejabat->nip ?? '........................' }}</p>
            </td>
        </tr>
    </table>
</body>

</html>