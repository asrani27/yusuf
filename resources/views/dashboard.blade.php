@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
    <p class="text-sm text-gray-500">Selamat datang, {{ auth()->user()->username }}!</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">Total Pegawai</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPegawai }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Total SPT</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSpt }}</p>
        <p class="text-xs text-gray-400 mt-1">Draft: {{ $sptDraft }} | Disetujui: {{ $sptDisetujui }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500">Total SPPD</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSppd }}</p>
        <p class="text-xs text-gray-400 mt-1">Menunggu: {{ $sppdMenunggu }} | Selesai: {{ $sppdSelesai }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
        <p class="text-sm text-gray-500">Total User</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalUsers }}</p>
    </div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">SPT Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b"><th class="text-left py-2 text-gray-600">Nomor SPT</th><th class="text-left py-2 text-gray-600">Tujuan</th><th class="text-left py-2 text-gray-600">Status</th></tr></thead>
                <tbody>
                @forelse($recentSpt as $spt)
                    <tr class="border-b border-gray-50">
                        <td class="py-2">{{ $spt->nomor_spt }}</td>
                        <td class="py-2">{{ $spt->tujuan->kota_tujuan ?? '-' }}</td>
                        <td class="py-2"><span class="px-2 py-0.5 rounded-full text-xs {{ $spt->status_spt == 'disetujui' ? 'bg-green-100 text-green-800' : ($spt->status_spt == 'draft' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">{{ ucfirst($spt->status_spt) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="py-4 text-center text-gray-400">Belum ada data SPT</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">SPPD Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="border-b"><th class="text-left py-2 text-gray-600">Nomor SPPD</th><th class="text-left py-2 text-gray-600">Pegawai</th><th class="text-left py-2 text-gray-600">Status</th></tr></thead>
                <tbody>
                @forelse($recentSppd as $sppd)
                    <tr class="border-b border-gray-50">
                        <td class="py-2">{{ $sppd->nomor_sppd }}</td>
                        <td class="py-2">{{ $sppd->pegawai->nama_pegawai ?? '-' }}</td>
                        <td class="py-2"><span class="px-2 py-0.5 rounded-full text-xs {{ $sppd->status_sppd == 'selesai' ? 'bg-green-100 text-green-800' : ($sppd->status_sppd == 'draft' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800') }}">{{ ucfirst(str_replace('_', ' ', $sppd->status_sppd)) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="py-4 text-center text-gray-400">Belum ada data SPPD</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
