@extends('layouts.app')
@section('title', 'Review Verifikasi')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Review Verifikasi SPPD</h2>
    <a href="{{ route('verifikasi.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold mb-4">Data SPPD</h3>
        <div class="space-y-3 text-sm">
            <div><span class="text-gray-500">Nomor:</span> <span class="font-medium">{{ $sppd->nomor_sppd }}</span></div>
            <div><span class="text-gray-500">SPT:</span> <span class="font-medium">{{ $sppd->spt->nomor_spt ?? '-' }}</span></div>
            <div><span class="text-gray-500">Pegawai:</span> <span class="font-medium">{{ $sppd->pegawai->nama_pegawai ?? '-' }}</span></div>
            <div><span class="text-gray-500">NIP:</span> <span class="font-medium">{{ $sppd->pegawai->nip ?? '-' }}</span></div>
            <div><span class="text-gray-500">Tujuan:</span> <span class="font-medium">{{ $sppd->tempat_tujuan }}</span></div>
            <div><span class="text-gray-500">Tanggal:</span> <span class="font-medium">{{ $sppd->tanggal_berangkat->format('d/m/Y') }} s.d. {{ $sppd->tanggal_kembali->format('d/m/Y') }}</span></div>
            <div><span class="text-gray-500">Lama:</span> <span class="font-medium">{{ $sppd->lama_hari }} hari</span></div>
            <div><span class="text-gray-500">Maksud:</span> <span class="font-medium">{{ $sppd->spt->maksud_perjalanan ?? '-' }}</span></div>
        </div>
        @if($sppd->anggaran)
        <h4 class="font-semibold mt-4 mb-2">Anggaran</h4>
        <table class="w-full text-sm">
            <tr class="border-b"><td class="py-1 text-gray-600">Uang Harian</td><td class="py-1 text-right">Rp {{ number_format($sppd->anggaran->uang_harian,0,',','.') }}</td></tr>
            <tr class="border-b"><td class="py-1 text-gray-600">Transportasi</td><td class="py-1 text-right">Rp {{ number_format($sppd->anggaran->biaya_transportasi,0,',','.') }}</td></tr>
            <tr class="border-b"><td class="py-1 text-gray-600">Penginapan</td><td class="py-1 text-right">Rp {{ number_format($sppd->anggaran->biaya_penginapan,0,',','.') }}</td></tr>
            <tr class="border-b"><td class="py-1 text-gray-600">Taksi</td><td class="py-1 text-right">Rp {{ number_format($sppd->anggaran->biaya_taksi,0,',','.') }}</td></tr>
            <tr class="border-b"><td class="py-1 text-gray-600">Representasi</td><td class="py-1 text-right">Rp {{ number_format($sppd->anggaran->biaya_representasi,0,',','.') }}</td></tr>
            <tr class="border-b"><td class="py-1 text-gray-600">Lainnya</td><td class="py-1 text-right">Rp {{ number_format($sppd->anggaran->biaya_lainnya,0,',','.') }}</td></tr>
            <tr class="bg-blue-50 font-bold"><td class="py-2">Total</td><td class="py-2 text-right text-blue-700">Rp {{ number_format($sppd->anggaran->total_biaya,0,',','.') }}</td></tr>
        </table>
        @endif
    </div>
    <div>
        @if($sppd->status_sppd == 'menunggu_verifikasi')
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Form Verifikasi</h3>
            <form method="POST" action="{{ route('verifikasi.store', $sppd) }}">@csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keputusan *</label>
                    <select name="status_verifikasi" class="w-full px-4 py-2 border rounded-lg text-sm" required>
                        <option value="">-- Pilih --</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="perbaikan">Perlu Perbaikan</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <textarea name="catatan" rows="4" class="w-full px-4 py-2 border rounded-lg text-sm" placeholder="Catatan verifikasi..."></textarea>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700">Simpan Verifikasi</button>
            </form>
        </div>
        @endif
        @if($sppd->verifikasi->count())
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">Riwayat Verifikasi</h3>
            @foreach($sppd->verifikasi->sortByDesc('created_at') as $v)
            <div class="border-b pb-3 mb-3">
                <div class="flex justify-between">
                    <span class="text-sm font-medium">{{ $v->verifikator->username ?? '-' }}</span>
                    <span class="text-xs text-gray-400">{{ $v->tanggal_verifikasi->format('d/m/Y H:i') }}</span>
                </div>
                <span class="px-2 py-0.5 rounded-full text-xs {{ $v->status_verifikasi=='disetujui'?'bg-green-100 text-green-800':($v->status_verifikasi=='ditolak'?'bg-red-100 text-red-800':'bg-yellow-100 text-yellow-800') }}">{{ ucfirst($v->status_verifikasi) }}</span>
                @if($v->catatan)<p class="text-sm text-gray-600 mt-1">{{ $v->catatan }}</p>@endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
