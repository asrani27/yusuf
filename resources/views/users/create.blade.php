@extends('layouts.app')
@section('title', 'Tambah User')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Tambah User</h2>
    <a href="{{ route('users.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
</div>
@if($errors->any())<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"><ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<div class="bg-white rounded-xl shadow-sm p-6">
    <form method="POST" action="{{ route('users.store') }}">@csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Pegawai (opsional)</label><select name="pegawai_id" class="w-full select2-pegawai"><option value="">-- Tidak dikaitkan --</option>@foreach($pegawaiList as $p)<option value="{{ $p->id }}" {{ old('pegawai_id')==$p->id?'selected':'' }}>{{ $p->nip }} - {{ $p->nama_pegawai }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Username *</label><input type="text" name="username" value="{{ old('username') }}" class="w-full px-4 py-2 border rounded-lg text-sm" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Email *</label><input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border rounded-lg text-sm" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Password *</label><input type="password" name="password" class="w-full px-4 py-2 border rounded-lg text-sm" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password *</label><input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg text-sm" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Role *</label><select name="role" class="w-full px-4 py-2 border rounded-lg text-sm" required><option value="admin" {{ old('role')=='admin'?'selected':'' }}>Admin</option><option value="pejabat" {{ old('role')=='pejabat'?'selected':'' }}>Pejabat</option><option value="verifikator" {{ old('role')=='verifikator'?'selected':'' }}>Verifikator</option><option value="pegawai" {{ old('role')=='pegawai'?'selected':'' }}>Pegawai</option></select></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Status *</label><select name="status" class="w-full px-4 py-2 border rounded-lg text-sm" required><option value="aktif" {{ old('status','aktif')=='aktif'?'selected':'' }}>Aktif</option><option value="nonaktif" {{ old('status')=='nonaktif'?'selected':'' }}>Nonaktif</option></select></div>
        </div>
        <div class="mt-6"><button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700">Simpan</button></div>
    </form>
</div>
@endsection
@push('scripts')<script>$(document).ready(function(){$('.select2-pegawai').select2({width:'100%',placeholder:'-- Pilih Pegawai --',allowClear:true});});</script>@endpush
