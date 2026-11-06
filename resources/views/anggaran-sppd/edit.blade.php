@extends('layouts.app')
@section('title', 'Edit Anggaran SPPD')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Edit Anggaran SPPD</h2>
    <p class="text-sm text-gray-500">SPPD: {{ $sppd->nomor_sppd }}</p>
    <a href="{{ route('sppd.show', $sppd) }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
</div>
@if($errors->any())<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"><ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
<div class="bg-white rounded-xl shadow-sm p-6">
    <form method="POST" action="{{ route('anggaran-sppd.update', $sppd) }}">@csrf @method('PUT')
        @include('anggaran-sppd._form')
        <div class="mt-6"><button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700">Perbarui Anggaran</button></div>
    </form>
</div>
@endsection
@push('scripts')
<script>
function hitungTotal(){
    const fields = ['uang_harian','biaya_transportasi','biaya_penginapan','biaya_taksi','biaya_representasi','biaya_lainnya'];
    let total = 0;
    fields.forEach(f => { total += parseFloat(document.getElementById(f).value) || 0; });
    document.getElementById('total_display').textContent = 'Rp ' + total.toLocaleString('id-ID');
}
document.querySelectorAll('.biaya-input').forEach(el => el.addEventListener('input', hitungTotal));
hitungTotal();
</script>
@endpush
