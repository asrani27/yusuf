@extends('layouts.app')
@section('title', 'Verifikasi SPPD')
@section('content')
@php
    $daftarBulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $tahunIni = (int) date('Y');
    $daftarTahun = range($tahunIni + 1, $tahunIni - 4);
    if (request('tahun') && !in_array((int) request('tahun'), $daftarTahun)) {
        $daftarTahun[] = (int) request('tahun');
        rsort($daftarTahun);
    }
@endphp
<div class="mb-6"><h2 class="text-2xl font-bold text-gray-800">Verifikasi SPPD</h2></div>
<div class="bg-white rounded-xl shadow-sm p-6">
    <form method="GET" class="mb-4">
        <div class="flex flex-wrap items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor SPPD, pegawai..." class="flex-1 min-w-[180px] px-4 py-2 border border-gray-300 rounded-lg text-sm">
            
            <select name="bulan" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <option value="">Semua Bulan</option>
                @foreach($daftarBulan as $blnNum => $blnNama)
                    <option value="{{ $blnNum }}" {{ request('bulan') == $blnNum ? 'selected' : '' }}>{{ $blnNama }}</option>
                @endforeach
            </select>

            <select name="tahun" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <option value="">Semua Tahun</option>
                @foreach($daftarTahun as $thn)
                    <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                @endforeach
            </select>

            <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <option value="">Semua Status</option>
                <option value="menunggu_verifikasi" {{ request('status')=='menunggu_verifikasi'?'selected':'' }}>Menunggu Verifikasi</option>
                <option value="diverifikasi" {{ request('status')=='diverifikasi'?'selected':'' }}>Diverifikasi</option>
                <option value="ditolak" {{ request('status')=='ditolak'?'selected':'' }}>Ditolak</option>
                <option value="selesai" {{ request('status')=='selesai'?'selected':'' }}>Selesai</option>
            </select>

            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700">Filter</button>
            
            @if(request('search') || request('bulan') || request('tahun') || request('status'))
                <a href="{{ route('verifikasi.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-300">Reset</a>
            @endif

            <button type="submit" formaction="{{ route('cetak.verifikasi.rekap') }}" formtarget="_blank" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 flex items-center gap-1.5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak</span>
            </button>
        </div>
    </form>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="bg-gray-50 border-b"><th class="text-left px-4 py-3">Nomor SPPD</th><th class="text-left px-4 py-3">Pegawai</th><th class="text-left px-4 py-3">SPT</th><th class="text-left px-4 py-3">Status</th><th class="text-center px-4 py-3">Aksi</th></tr></thead>
            <tbody>
            @forelse($sppdList as $sppd)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $sppd->nomor_sppd }}</td>
                    <td class="px-4 py-3">{{ $sppd->pegawai->nama_pegawai ?? '-' }}</td>
                    <td class="px-4 py-3 text-xs">{{ $sppd->spt->nomor_spt ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @php $c=['menunggu_verifikasi'=>'bg-yellow-100 text-yellow-800','diverifikasi'=>'bg-blue-100 text-blue-800','ditolak'=>'bg-red-100 text-red-800','selesai'=>'bg-green-100 text-green-800']; @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs {{ $c[$sppd->status_sppd] ?? 'bg-gray-100' }}">{{ ucfirst(str_replace('_',' ',$sppd->status_sppd)) }}</span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('verifikasi.show', $sppd) }}" class="text-blue-600 hover:underline text-xs">Review</a>
                        @if($sppd->status_sppd == 'diverifikasi')
                        <form method="POST" action="{{ route('verifikasi.selesai', $sppd) }}" class="inline">@csrf @method('PATCH')<button class="text-green-600 hover:underline text-xs ml-2">Selesai</button></form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada SPPD untuk diverifikasi</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $sppdList->links() }}</div>
</div>
@endsection
