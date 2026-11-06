@extends('layouts.app')
@section('title', 'Detail Pegawai')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Detail Pegawai</h2>
    <a href="{{ route('pegawai.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
</div>
<div class="bg-white rounded-xl shadow-sm p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><p class="text-xs text-gray-500">NIP</p><p class="font-medium">{{ $pegawai->nip }}</p></div>
        <div><p class="text-xs text-gray-500">Nama</p><p class="font-medium">{{ $pegawai->nama_pegawai }}</p></div>
        <div><p class="text-xs text-gray-500">Tempat, Tanggal Lahir</p><p class="font-medium">{{ $pegawai->tempat_lahir }}, {{ $pegawai->tanggal_lahir->format('d-m-Y') }}</p></div>
        <div><p class="text-xs text-gray-500">Jenis Kelamin</p><p class="font-medium">{{ $pegawai->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p></div>
        <div><p class="text-xs text-gray-500">Pangkat/Golongan</p><p class="font-medium">{{ $pegawai->pangkat_golongan }}</p></div>
        <div><p class="text-xs text-gray-500">Jabatan</p><p class="font-medium">{{ $pegawai->jabatan }}</p></div>
        <div><p class="text-xs text-gray-500">Unit Kerja</p><p class="font-medium">{{ $pegawai->unit_kerja }}</p></div>
        <div><p class="text-xs text-gray-500">Nomor HP</p><p class="font-medium">{{ $pegawai->nomor_hp ?? '-' }}</p></div>
        <div><p class="text-xs text-gray-500">Status Pegawai</p><p class="font-medium">{{ $pegawai->status_pegawai }}</p></div>
        <div><p class="text-xs text-gray-500">Pejabat Penandatangan</p><p class="font-medium">{{ $pegawai->is_pejabat ? 'Ya' : 'Tidak' }}</p></div>
        @if($pegawai->is_pejabat)
        <div><p class="text-xs text-gray-500">Nomor SK Pejabat</p><p class="font-medium">{{ $pegawai->nomor_sk_pejabat ?? '-' }}</p></div>
        @endif
        <div class="md:col-span-2"><p class="text-xs text-gray-500">Alamat</p><p class="font-medium">{{ $pegawai->alamat ?? '-' }}</p></div>
    </div>
</div>
@endsection
