@extends('layouts.app')
@section('title', 'Detail SPT')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Detail SPT</h2>
    <a href="{{ route('spt.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
</div>
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex justify-between items-start mb-4">
        <h3 class="text-lg font-semibold">{{ $spt->nomor_spt }}</h3>
        <div class="flex items-center gap-2">
            @php $colors = ['draft'=>'bg-gray-100 text-gray-800','diajukan'=>'bg-yellow-100 text-yellow-800','disetujui'=>'bg-green-100 text-green-800','ditolak'=>'bg-red-100 text-red-800']; @endphp
            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $colors[$spt->status_spt] ?? '' }}">{{ ucfirst($spt->status_spt) }}</span>
            <a href="{{ route('cetak.spt', $spt) }}" target="_blank" class="bg-green-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-green-700">Cetak PDF</a>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div><p class="text-xs text-gray-500">Pejabat Penandatangan</p><p class="font-medium">{{ $spt->pejabat->nama_pegawai ?? '-' }}</p></div>
        <div><p class="text-xs text-gray-500">Jabatan</p><p class="font-medium">{{ $spt->pejabat->jabatan ?? '-' }}</p></div>
        <div><p class="text-xs text-gray-500">Tujuan</p><p class="font-medium">{{ $spt->tujuan->kota_tujuan ?? '-' }}, {{ $spt->tujuan->provinsi_tujuan ?? '' }}</p></div>
        <div><p class="text-xs text-gray-500">Instansi Tujuan</p><p class="font-medium">{{ $spt->tujuan->instansi_tujuan ?? '-' }}</p></div>
        <div><p class="text-xs text-gray-500">Tanggal Berangkat</p><p class="font-medium">{{ $spt->tanggal_berangkat->format('d/m/Y') }}</p></div>
        <div><p class="text-xs text-gray-500">Tanggal Kembali</p><p class="font-medium">{{ $spt->tanggal_kembali->format('d/m/Y') }}</p></div>
        <div><p class="text-xs text-gray-500">Lama Hari</p><p class="font-medium">{{ $spt->lama_hari }} hari</p></div>
        <div><p class="text-xs text-gray-500">Transportasi</p><p class="font-medium">{{ $spt->transportasi }}</p></div>
        <div class="md:col-span-2"><p class="text-xs text-gray-500">Maksud Perjalanan</p><p class="font-medium">{{ $spt->maksud_perjalanan }}</p></div>
        <div class="md:col-span-2"><p class="text-xs text-gray-500">Dasar Penugasan</p><p class="font-medium">{{ $spt->dasar_penugasan ?? '-' }}</p></div>
    </div>
    @if($spt->status_spt == 'draft')
    <div class="mt-4 pt-4 border-t">
        <form method="POST" action="{{ route('spt.update-status', $spt) }}" class="inline">@csrf @method('PATCH')
            <input type="hidden" name="status_spt" value="diajukan">
            <button class="bg-yellow-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-600">Ajukan SPT</button>
        </form>
    </div>
    @elseif($spt->status_spt == 'diajukan' && auth()->user()->isAdmin())
    <div class="mt-4 pt-4 border-t flex gap-2">
        <form method="POST" action="{{ route('spt.update-status', $spt) }}" class="inline">@csrf @method('PATCH')
            <input type="hidden" name="status_spt" value="disetujui">
            <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">Setujui</button>
        </form>
        <form method="POST" action="{{ route('spt.update-status', $spt) }}" class="inline">@csrf @method('PATCH')
            <input type="hidden" name="status_spt" value="ditolak">
            <button class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700">Tolak</button>
        </form>
    </div>
    @endif
</div>
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <h3 class="text-lg font-semibold mb-4">Pegawai yang Ditugaskan</h3>
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50 border-b"><th class="text-left px-4 py-2">No</th><th class="text-left px-4 py-2">NIP</th><th class="text-left px-4 py-2">Nama</th><th class="text-left px-4 py-2">Jabatan</th><th class="text-left px-4 py-2">Peran</th></tr></thead>
        <tbody>
        @foreach($spt->pengikut as $i => $p)
            <tr class="border-b"><td class="px-4 py-2">{{ $i+1 }}</td><td class="px-4 py-2 font-mono text-xs">{{ $p->nip }}</td><td class="px-4 py-2">{{ $p->nama_pegawai }}</td><td class="px-4 py-2">{{ $p->jabatan }}</td><td class="px-4 py-2">{{ $p->pivot->peran_tugas }}</td></tr>
        @endforeach
        </tbody>
    </table>
</div>
@if($spt->sppd->count())
<div class="bg-white rounded-xl shadow-sm p-6">
    <h3 class="text-lg font-semibold mb-4">SPPD Terkait</h3>
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50 border-b"><th class="text-left px-4 py-2">Nomor SPPD</th><th class="text-left px-4 py-2">Pegawai</th><th class="text-left px-4 py-2">Status</th><th class="text-center px-4 py-2">Aksi</th></tr></thead>
        <tbody>
        @foreach($spt->sppd as $sppd)
            <tr class="border-b"><td class="px-4 py-2">{{ $sppd->nomor_sppd }}</td><td class="px-4 py-2">{{ $sppd->pegawai->nama_pegawai ?? '-' }}</td><td class="px-4 py-2"><span class="px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-800">{{ ucfirst(str_replace('_',' ',$sppd->status_sppd)) }}</span></td><td class="px-4 py-2 text-center"><a href="{{ route('sppd.show', $sppd) }}" class="text-blue-600 hover:underline text-xs">Detail</a></td></tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
