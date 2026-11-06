@extends('layouts.app')
@section('title', 'Edit SPPD')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Edit SPPD</h2>
    <a href="{{ route('sppd.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
</div>
@if($errors->any())
<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"><ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif
<div class="bg-white rounded-xl shadow-sm p-6">
    <form method="POST" action="{{ route('sppd.update', $sppd) }}">@csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Nomor SPPD *</label><input type="text" name="nomor_sppd" value="{{ old('nomor_sppd', $sppd->nomor_sppd) }}" class="w-full px-4 py-2 border rounded-lg text-sm" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">SPT *</label><select name="spt_id" class="w-full select2-spt" required>@foreach($sptList as $s)<option value="{{ $s->id }}" {{ old('spt_id',$sppd->spt_id)==$s->id?'selected':'' }}>{{ $s->nomor_spt }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Pegawai *</label><select name="pegawai_id" class="w-full select2-pegawai" required>@foreach($sppd->spt->pengikut as $p)<option value="{{ $p->id }}" {{ old('pegawai_id',$sppd->pegawai_id)==$p->id?'selected':'' }}>{{ $p->nip }} - {{ $p->nama_pegawai }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Alat Angkut *</label><select name="alat_angkut" class="w-full px-4 py-2 border rounded-lg text-sm" required><option value="Darat" {{ old('alat_angkut',$sppd->alat_angkut)=='Darat'?'selected':'' }}>Darat</option><option value="Udara" {{ old('alat_angkut',$sppd->alat_angkut)=='Udara'?'selected':'' }}>Udara</option><option value="Air" {{ old('alat_angkut',$sppd->alat_angkut)=='Air'?'selected':'' }}>Air</option></select></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Tempat Berangkat *</label><input type="text" name="tempat_berangkat" value="{{ old('tempat_berangkat', $sppd->tempat_berangkat) }}" class="w-full px-4 py-2 border rounded-lg text-sm" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Tempat Tujuan *</label><input type="text" name="tempat_tujuan" value="{{ old('tempat_tujuan', $sppd->tempat_tujuan) }}" class="w-full px-4 py-2 border rounded-lg text-sm" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Tgl Berangkat *</label><input type="date" name="tanggal_berangkat" id="tgl_berangkat" value="{{ old('tanggal_berangkat', $sppd->tanggal_berangkat->format('Y-m-d')) }}" class="w-full px-4 py-2 border rounded-lg text-sm" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Tgl Kembali *</label><input type="date" name="tanggal_kembali" id="tgl_kembali" value="{{ old('tanggal_kembali', $sppd->tanggal_kembali->format('Y-m-d')) }}" class="w-full px-4 py-2 border rounded-lg text-sm" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Lama Hari</label><input type="number" name="lama_hari" id="lama_hari" value="{{ old('lama_hari', $sppd->lama_hari) }}" class="w-full px-4 py-2 border rounded-lg text-sm bg-gray-50" readonly required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Biaya</label><input type="text" name="tingkat_biaya" value="{{ old('tingkat_biaya', $sppd->tingkat_biaya) }}" class="w-full px-4 py-2 border rounded-lg text-sm"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Pembebanan Anggaran *</label><input type="text" name="pembebanan_anggaran" value="{{ old('pembebanan_anggaran', $sppd->pembebanan_anggaran) }}" class="w-full px-4 py-2 border rounded-lg text-sm" required></div>
            <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label><textarea name="keterangan" rows="2" class="w-full px-4 py-2 border rounded-lg text-sm">{{ old('keterangan', $sppd->keterangan) }}</textarea></div>
        </div>
        <div class="mt-6"><button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700">Perbarui SPPD</button></div>
    </form>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function(){$('.select2-spt').select2({width:'100%'});$('.select2-pegawai').select2({width:'100%'});});
document.getElementById('tgl_berangkat').addEventListener('change', hitungHari);
document.getElementById('tgl_kembali').addEventListener('change', hitungHari);
function hitungHari(){const b=document.getElementById('tgl_berangkat').value;const k=document.getElementById('tgl_kembali').value;if(b&&k){const d=Math.ceil((new Date(k)-new Date(b))/(1000*60*60*24))+1;document.getElementById('lama_hari').value=d>0?d:1;}}
</script>
@endpush
