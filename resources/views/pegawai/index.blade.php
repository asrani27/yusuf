@extends('layouts.app')
@section('title', 'Data Pegawai')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Data Pegawai</h2>
    <a href="{{ route('pegawai.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">+ Tambah Pegawai</a>
</div>
<div class="bg-white rounded-xl shadow-sm p-6">
    <form method="GET" class="mb-4">
        <div class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIP, nama, jabatan..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700">Cari</button>
        </div>
    </form>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="bg-gray-50 border-b"><th class="text-left px-4 py-3">NIP</th><th class="text-left px-4 py-3">Nama</th><th class="text-left px-4 py-3">Jabatan</th><th class="text-left px-4 py-3">Pangkat</th><th class="text-left px-4 py-3">Status</th><th class="text-left px-4 py-3">Pejabat</th><th class="text-center px-4 py-3">Aksi</th></tr></thead>
            <tbody>
            @forelse($pegawai as $p)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 font-mono text-xs">{{ $p->nip }}</td>
                    <td class="px-4 py-3">{{ $p->nama_pegawai }}</td>
                    <td class="px-4 py-3">{{ $p->jabatan }}</td>
                    <td class="px-4 py-3 text-xs">{{ $p->pangkat_golongan }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $p->status_pegawai == 'PNS' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">{{ $p->status_pegawai }}</span></td>
                    <td class="px-4 py-3">{{ $p->is_pejabat ? 'Ya' : '-' }}</td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('pegawai.show', $p) }}" class="text-blue-600 hover:underline text-xs">Detail</a>
                        <a href="{{ route('pegawai.edit', $p) }}" class="text-yellow-600 hover:underline text-xs ml-2">Edit</a>
                        <form method="POST" action="{{ route('pegawai.destroy', $p) }}" class="inline" onsubmit="return confirm('Hapus data pegawai ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline text-xs ml-2">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">Belum ada data pegawai</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $pegawai->links() }}</div>
</div>
@endsection
