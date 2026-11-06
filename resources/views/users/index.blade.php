@extends('layouts.app')
@section('title', 'Manajemen User')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Manajemen User</h2>
    <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">+ Tambah User</a>
</div>
<div class="bg-white rounded-xl shadow-sm p-6">
    <form method="GET" class="mb-4"><div class="flex gap-2"><input type="text" name="search" value="{{ request('search') }}" placeholder="Cari username, email..." class="flex-1 px-4 py-2 border rounded-lg text-sm"><button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">Cari</button></div></form>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="bg-gray-50 border-b"><th class="text-left px-4 py-3">Username</th><th class="text-left px-4 py-3">Email</th><th class="text-left px-4 py-3">Pegawai</th><th class="text-left px-4 py-3">Role</th><th class="text-left px-4 py-3">Status</th><th class="text-center px-4 py-3">Aksi</th></tr></thead>
            <tbody>
            @forelse($users as $u)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $u->username }}</td>
                    <td class="px-4 py-3">{{ $u->email }}</td>
                    <td class="px-4 py-3 text-xs">{{ $u->pegawai->nama_pegawai ?? '-' }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-800">{{ ucfirst($u->role) }}</span></td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs {{ $u->status=='aktif'?'bg-green-100 text-green-800':'bg-red-100 text-red-800' }}">{{ ucfirst($u->status) }}</span></td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('users.edit', $u) }}" class="text-yellow-600 hover:underline text-xs">Edit</a>
                        @if($u->id !== auth()->id())
                        <form method="POST" action="{{ route('users.destroy', $u) }}" class="inline" onsubmit="return confirm('Hapus user ini?')">@csrf @method('DELETE')<button class="text-red-600 hover:underline text-xs ml-2">Hapus</button></form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada data</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
