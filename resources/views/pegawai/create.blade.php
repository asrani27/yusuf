@extends('layouts.app')
@section('title', 'Tambah Pegawai')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Tambah Pegawai</h2>
    <a href="{{ route('pegawai.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
</div>
<div class="bg-white rounded-xl shadow-sm p-6">
    <form method="POST" action="{{ route('pegawai.store') }}">
        @csrf
        @include('pegawai._form')
        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
