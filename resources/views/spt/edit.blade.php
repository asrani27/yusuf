@extends('layouts.app')
@section('title', 'Edit SPT')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Edit Surat Perintah Tugas</h2>
    <a href="{{ route('spt.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
</div>
@if($errors->any())
<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"><ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif
<div class="bg-white rounded-xl shadow-sm p-6">
    <form method="POST" action="{{ route('spt.update', $spt) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Nomor SPT *</label><input type="text" name="nomor_spt" value="{{ old('nomor_spt', $spt->nomor_spt) }}" class="w-full px-4 py-2 border rounded-lg text-sm" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Pejabat *</label><select name="pejabat_id" class="w-full select2-pejabat" required><option value="">-- Pilih --</option>@foreach($pejabat as $p)<option value="{{ $p->id }}" {{ old('pejabat_id',$spt->pejabat_id)==$p->id?'selected':'' }}>{{ $p->nip }} - {{ $p->nama_pegawai }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Tujuan *</label><select name="tujuan_id" class="w-full select2-tujuan" required><option value="">-- Pilih --</option>@foreach($tujuan as $t)<option value="{{ $t->id }}" {{ old('tujuan_id',$spt->tujuan_id)==$t->id?'selected':'' }}>{{ $t->kota_tujuan }}, {{ $t->provinsi_tujuan }} - {{ $t->instansi_tujuan }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Transportasi *</label><select name="transportasi" class="w-full px-4 py-2 border rounded-lg text-sm" required><option value="Darat" {{ old('transportasi',$spt->transportasi)=='Darat'?'selected':'' }}>Darat</option><option value="Udara" {{ old('transportasi',$spt->transportasi)=='Udara'?'selected':'' }}>Udara</option><option value="Air" {{ old('transportasi',$spt->transportasi)=='Air'?'selected':'' }}>Air</option></select></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Tgl Berangkat *</label><input type="date" name="tanggal_berangkat" id="tgl_berangkat" value="{{ old('tanggal_berangkat', $spt->tanggal_berangkat->format('Y-m-d')) }}" class="w-full px-4 py-2 border rounded-lg text-sm" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Tgl Kembali *</label><input type="date" name="tanggal_kembali" id="tgl_kembali" value="{{ old('tanggal_kembali', $spt->tanggal_kembali->format('Y-m-d')) }}" class="w-full px-4 py-2 border rounded-lg text-sm" required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Lama Hari</label><input type="number" name="lama_hari" id="lama_hari" value="{{ old('lama_hari', $spt->lama_hari) }}" class="w-full px-4 py-2 border rounded-lg text-sm bg-gray-50" readonly required></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Dasar Penugasan</label><textarea name="dasar_penugasan" rows="2" class="w-full px-4 py-2 border rounded-lg text-sm">{{ old('dasar_penugasan', $spt->dasar_penugasan) }}</textarea></div>
            <div class="md:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Maksud Perjalanan *</label><textarea name="maksud_perjalanan" rows="3" class="w-full px-4 py-2 border rounded-lg text-sm" required>{{ old('maksud_perjalanan', $spt->maksud_perjalanan) }}</textarea></div>
        </div>
        <div class="border-t pt-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Pegawai yang Ditugaskan</h3>
                <button type="button" onclick="addPengikut()" class="bg-green-600 text-white px-3 py-1.5 rounded-lg text-sm">+ Tambah</button>
            </div>
            <div id="pengikut-container">
                @foreach($spt->pengikut as $i => $pk)
                <div class="pengikut-row flex gap-4 items-end mb-3">
                    <div class="flex-1"><label class="block text-xs text-gray-500 mb-1">Pegawai</label>
                        <select name="pengikut[{{ $i }}][pegawai_id]" class="w-full select2-pegawai" required>
                            <option value="">-- Pilih --</option>
                            @foreach($pegawai as $p)<option value="{{ $p->id }}" {{ $pk->id==$p->id?'selected':'' }}>{{ $p->nip }} - {{ $p->nama_pegawai }}</option>@endforeach
                        </select>
                    </div>
                    <div class="w-48"><label class="block text-xs text-gray-500 mb-1">Peran</label><input type="text" name="pengikut[{{ $i }}][peran_tugas]" value="{{ $pk->pivot->peran_tugas }}" class="w-full px-3 py-2 border rounded-lg text-sm" required></div>
                    <button type="button" onclick="this.closest('.pengikut-row').remove()" class="text-red-500 pb-2">&times;</button>
                </div>
                @endforeach
            </div>
        </div>
        <div class="mt-6"><button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700">Perbarui SPT</button></div>
    </form>
</div>
@endsection
@push('scripts')
<script>
let pengikutIndex = {{ $spt->pengikut->count() }};
function addPengikut(){
    const c = document.getElementById('pengikut-container');
    const opts = document.querySelector('.select2-pegawai').innerHTML;
    c.insertAdjacentHTML('beforeend', `<div class="pengikut-row flex gap-4 items-end mb-3"><div class="flex-1"><label class="block text-xs text-gray-500 mb-1">Pegawai</label><select name="pengikut[${pengikutIndex}][pegawai_id]" class="w-full select2-pegawai-d" required>${opts}</select></div><div class="w-48"><label class="block text-xs text-gray-500 mb-1">Peran</label><input type="text" name="pengikut[${pengikutIndex}][peran_tugas]" value="Anggota" class="w-full px-3 py-2 border rounded-lg text-sm" required></div><button type="button" onclick="this.closest('.pengikut-row').remove()" class="text-red-500 pb-2">&times;</button></div>`);
    $(c).find('.select2-pegawai-d').last().select2({width:'100%'});
    pengikutIndex++;
}
$(document).ready(function(){$('.select2-pejabat').select2({width:'100%'});$('.select2-tujuan').select2({width:'100%'});$('.select2-pegawai').select2({width:'100%'});});
document.getElementById('tgl_berangkat').addEventListener('change', hitungHari);
document.getElementById('tgl_kembali').addEventListener('change', hitungHari);
function hitungHari(){const b=document.getElementById('tgl_berangkat').value;const k=document.getElementById('tgl_kembali').value;if(b&&k){const d=Math.ceil((new Date(k)-new Date(b))/(1000*60*60*24))+1;document.getElementById('lama_hari').value=d>0?d:1;}}
</script>
@endpush
