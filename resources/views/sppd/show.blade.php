@extends('layouts.app')
@section('title', 'Detail SPPD')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Detail SPPD</h2>
    <a href="{{ route('sppd.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
</div>
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex justify-between items-start mb-4">
        <h3 class="text-lg font-semibold">{{ $sppd->nomor_sppd }}</h3>
        <div class="flex items-center gap-2">
            @php $c=['draft'=>'bg-gray-100 text-gray-800','menunggu_verifikasi'=>'bg-yellow-100 text-yellow-800','diverifikasi'=>'bg-blue-100 text-blue-800','ditolak'=>'bg-red-100 text-red-800','selesai'=>'bg-green-100 text-green-800']; @endphp
            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $c[$sppd->status_sppd] ?? '' }}">{{ ucfirst(str_replace('_',' ',$sppd->status_sppd)) }}</span>
            <a href="{{ route('cetak.sppd', $sppd) }}" target="_blank" class="bg-green-600 text-white px-3 py-1 rounded-lg text-xs">Cetak SPPD</a>
            @if($sppd->anggaran)
            <a href="{{ route('cetak.kuitansi', $sppd) }}" target="_blank" class="bg-purple-600 text-white px-3 py-1 rounded-lg text-xs">Cetak Kuitansi</a>
            @endif
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div><p class="text-xs text-gray-500">SPT</p><p class="font-medium">{{ $sppd->spt->nomor_spt ?? '-' }}</p></div>
        <div><p class="text-xs text-gray-500">Pegawai</p><p class="font-medium">{{ $sppd->pegawai->nama_pegawai ?? '-' }} ({{ $sppd->pegawai->nip ?? '' }})</p></div>
        <div><p class="text-xs text-gray-500">Jabatan</p><p class="font-medium">{{ $sppd->pegawai->jabatan ?? '-' }}</p></div>
        <div><p class="text-xs text-gray-500">Pangkat</p><p class="font-medium">{{ $sppd->pegawai->pangkat_golongan ?? '-' }}</p></div>
        <div><p class="text-xs text-gray-500">Tempat Berangkat</p><p class="font-medium">{{ $sppd->tempat_berangkat }}</p></div>
        <div><p class="text-xs text-gray-500">Tempat Tujuan</p><p class="font-medium">{{ $sppd->tempat_tujuan }}</p></div>
        <div><p class="text-xs text-gray-500">Tgl Berangkat</p><p class="font-medium">{{ $sppd->tanggal_berangkat->format('d/m/Y') }}</p></div>
        <div><p class="text-xs text-gray-500">Tgl Kembali</p><p class="font-medium">{{ $sppd->tanggal_kembali->format('d/m/Y') }}</p></div>
        <div><p class="text-xs text-gray-500">Lama</p><p class="font-medium">{{ $sppd->lama_hari }} hari</p></div>
        <div><p class="text-xs text-gray-500">Alat Angkut</p><p class="font-medium">{{ $sppd->alat_angkut }}</p></div>
        <div><p class="text-xs text-gray-500">Pembebanan</p><p class="font-medium">{{ $sppd->pembebanan_anggaran }}</p></div>
        <div><p class="text-xs text-gray-500">Pejabat Penandatangan</p><p class="font-medium">{{ $sppd->spt->pejabat->nama_pegawai ?? '-' }}</p></div>
        <div class="md:col-span-2"><p class="text-xs text-gray-500">Maksud Perjalanan</p><p class="font-medium">{{ $sppd->spt->maksud_perjalanan ?? '-' }}</p></div>
    </div>
    @if($sppd->status_sppd == 'draft')
    <div class="mt-4 pt-4 border-t flex gap-2">
        @if(!$sppd->anggaran)
        <a href="{{ route('anggaran-sppd.create', $sppd) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Isi Anggaran</a>
        @else
        <a href="{{ route('anggaran-sppd.edit', $sppd) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Edit Anggaran</a>
        <form method="POST" action="{{ route('sppd.ajukan', $sppd) }}">@csrf @method('PATCH')<button class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm">Ajukan Verifikasi</button></form>
        @endif
    </div>
    @endif
</div>
@if($sppd->anggaran)
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Rincian Anggaran</h3>
        @if($sppd->status_sppd == 'draft')
        <a href="{{ route('anggaran-sppd.edit', $sppd) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
        @endif
    </div>
    <table class="w-full text-sm">
        <tr class="border-b"><td class="py-2 text-gray-600">Uang Harian</td><td class="py-2 text-right font-medium">Rp {{ number_format($sppd->anggaran->uang_harian, 0, ',', '.') }}</td></tr>
        <tr class="border-b"><td class="py-2 text-gray-600">Biaya Transportasi</td><td class="py-2 text-right font-medium">Rp {{ number_format($sppd->anggaran->biaya_transportasi, 0, ',', '.') }}</td></tr>
        <tr class="border-b"><td class="py-2 text-gray-600">Biaya Penginapan</td><td class="py-2 text-right font-medium">Rp {{ number_format($sppd->anggaran->biaya_penginapan, 0, ',', '.') }}</td></tr>
        <tr class="border-b"><td class="py-2 text-gray-600">Biaya Taksi</td><td class="py-2 text-right font-medium">Rp {{ number_format($sppd->anggaran->biaya_taksi, 0, ',', '.') }}</td></tr>
        <tr class="border-b"><td class="py-2 text-gray-600">Biaya Representasi</td><td class="py-2 text-right font-medium">Rp {{ number_format($sppd->anggaran->biaya_representasi, 0, ',', '.') }}</td></tr>
        <tr class="border-b"><td class="py-2 text-gray-600">Biaya Lainnya</td><td class="py-2 text-right font-medium">Rp {{ number_format($sppd->anggaran->biaya_lainnya, 0, ',', '.') }}</td></tr>
        <tr class="bg-blue-50"><td class="py-2 font-bold">Total Biaya</td><td class="py-2 text-right font-bold text-blue-700">Rp {{ number_format($sppd->anggaran->total_biaya, 0, ',', '.') }}</td></tr>
    </table>
    <div class="mt-3 text-xs text-gray-500">Sumber Dana: {{ $sppd->anggaran->sumber_dana }} | Kode Rekening: {{ $sppd->anggaran->kode_rekening }} | TA: {{ $sppd->anggaran->tahun_anggaran }}</div>
</div>
@endif
@if($sppd->verifikasi->count())
<div class="bg-white rounded-xl shadow-sm p-6">
    <h3 class="text-lg font-semibold mb-4">Riwayat Verifikasi</h3>
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50 border-b"><th class="text-left px-4 py-2">Tanggal</th><th class="text-left px-4 py-2">Verifikator</th><th class="text-left px-4 py-2">Status</th><th class="text-left px-4 py-2">Catatan</th></tr></thead>
        <tbody>
        @foreach($sppd->verifikasi as $v)
            <tr class="border-b"><td class="px-4 py-2">{{ $v->tanggal_verifikasi->format('d/m/Y H:i') }}</td><td class="px-4 py-2">{{ $v->verifikator->username ?? '-' }}</td><td class="px-4 py-2">{{ ucfirst($v->status_verifikasi) }}</td><td class="px-4 py-2">{{ $v->catatan ?? '-' }}</td></tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
