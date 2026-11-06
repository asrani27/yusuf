@extends('layouts.app')
@section('title', 'Edit Pegawai')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Edit Pegawai</h2>
    <a href="{{ route('pegawai.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
</div>
<div class="bg-white rounded-xl shadow-sm p-6">
    <form method="POST" action="{{ route('pegawai.update', $pegawai) }}">
        @csrf @method('PUT')
        @include('pegawai._form')
        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700">Perbarui</button>
        </div>
    </form>
</div>
@endsection
