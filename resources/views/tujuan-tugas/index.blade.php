@extends('layouts.app')
@section('title', 'Tujuan Tugas')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Tujuan Tugas</h2>
    <a href="{{ route('tujuan-tugas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">+ Tambah Tujuan</a>
</div>
<div class="bg-white rounded-xl shadow-sm p-6">
    <form method="GET" class="mb-4"><div class="flex gap-2"><input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kota, provinsi, instansi..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm"><button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">Cari</button></div></form>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="bg-gray-50 border-b"><th class="text-left px-4 py-3">Kota</th><th class="text-left px-4 py-3">Provinsi</th><th class="text-left px-4 py-3">Instansi</th><th class="text-left px-4 py-3">Alamat</th><th class="text-center px-4 py-3">Aksi</th></tr></thead>
            <tbody>
            @forelse($tujuan as $t)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $t->kota_tujuan }}</td>
                    <td class="px-4 py-3">{{ $t->provinsi_tujuan }}</td>
                    <td class="px-4 py-3">{{ $t->instansi_tujuan }}</td>
                    <td class="px-4 py-3 text-xs">{{ Str::limit($t->alamat_tujuan, 50) }}</td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('tujuan-tugas.edit', $t) }}" class="text-yellow-600 hover:underline text-xs">Edit</a>
                        <form method="POST" action="{{ route('tujuan-tugas.destroy', $t) }}" class="inline" onsubmit="return confirm('Hapus data ini?')">@csrf @method('DELETE')<button class="text-red-600 hover:underline text-xs ml-2">Hapus</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada data</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $tujuan->links() }}</div>
</div>
@endsection
