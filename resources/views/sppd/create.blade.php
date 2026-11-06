@extends('layouts.app')
@section('title', 'Buat SPPD')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Buat SPPD</h2>
    <a href="{{ route('sppd.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
</div>
@if($errors->any())
<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm"><ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif
<div class="bg-white rounded-xl shadow-sm p-6">
    <form method="POST" action="{{ route('sppd.store') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor SPPD *</label>
                <input type="text" name="nomor_sppd" value="{{ old('nomor_sppd') }}" class="w-full px-4 py-2 border rounded-lg text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">SPT (hanya yang disetujui) *</label>
                <select name="spt_id" id="spt_select" class="w-full select2-spt" required>
                    <option value="">-- Pilih SPT --</option>
                    @foreach($sptList as $s)
                    <option value="{{ $s->id }}" {{ old('spt_id', request('spt_id'))==$s->id?'selected':'' }}>{{ $s->nomor_spt }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pegawai *</label>
                <select name="pegawai_id" id="pegawai_select" class="w-full select2-pegawai" required>
                    <option value="">-- Pilih SPT dulu --</option>
                    @if($selectedSpt)
                    @foreach($pengikutOptions as $p)
                    <option value="{{ $p->id }}" {{ old('pegawai_id')==$p->id?'selected':'' }}>{{ $p->nip }} - {{ $p->nama_pegawai }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alat Angkut *</label>
                <select name="alat_angkut" class="w-full px-4 py-2 border rounded-lg text-sm" required>
                    <option value="">-- Pilih --</option>
                    <option value="Darat" {{ old('alat_angkut')=='Darat'?'selected':'' }}>Darat</option>
                    <option value="Udara" {{ old('alat_angkut')=='Udara'?'selected':'' }}>Udara</option>
                    <option value="Air" {{ old('alat_angkut')=='Air'?'selected':'' }}>Air</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Berangkat *</label>
                <input type="text" name="tempat_berangkat" value="{{ old('tempat_berangkat', 'Kuala Kapuas') }}" class="w-full px-4 py-2 border rounded-lg text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Tujuan *</label>
                <input type="text" name="tempat_tujuan" id="tempat_tujuan" value="{{ old('tempat_tujuan', $selectedSpt->tujuan->kota_tujuan ?? '') }}" class="w-full px-4 py-2 border rounded-lg text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berangkat *</label>
                <input type="date" name="tanggal_berangkat" id="tgl_berangkat" value="{{ old('tanggal_berangkat', $selectedSpt ? $selectedSpt->tanggal_berangkat->format('Y-m-d') : '') }}" class="w-full px-4 py-2 border rounded-lg text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali *</label>
                <input type="date" name="tanggal_kembali" id="tgl_kembali" value="{{ old('tanggal_kembali', $selectedSpt ? $selectedSpt->tanggal_kembali->format('Y-m-d') : '') }}" class="w-full px-4 py-2 border rounded-lg text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lama Hari</label>
                <input type="number" name="lama_hari" id="lama_hari" value="{{ old('lama_hari', $selectedSpt->lama_hari ?? '') }}" class="w-full px-4 py-2 border rounded-lg text-sm bg-gray-50" readonly required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Biaya</label>
                <input type="text" name="tingkat_biaya" value="{{ old('tingkat_biaya') }}" class="w-full px-4 py-2 border rounded-lg text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pembebanan Anggaran *</label>
                <input type="text" name="pembebanan_anggaran" value="{{ old('pembebanan_anggaran', 'DPA SKPD DISKOMINFOSANTIK Kab. Kapuas') }}" class="w-full px-4 py-2 border rounded-lg text-sm" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                <textarea name="keterangan" rows="2" class="w-full px-4 py-2 border rounded-lg text-sm">{{ old('keterangan') }}</textarea>
            </div>
        </div>
        <div class="mt-6"><button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700">Simpan SPPD</button></div>
    </form>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function(){
    $('.select2-spt').select2({width:'100%',placeholder:'-- Pilih SPT --'});
    $('.select2-pegawai').select2({width:'100%',placeholder:'-- Pilih Pegawai --'});
    $('#spt_select').on('change', function(){
        var sptId = $(this).val();
        if(!sptId) return;
        $.get('/api/spt/'+sptId+'/pengikut', function(data){
            var sel = $('#pegawai_select');
            sel.empty().append('<option value="">-- Pilih Pegawai --</option>');
            data.pengikut.forEach(function(p){ sel.append('<option value="'+p.id+'">'+p.nip+' - '+p.nama_pegawai+'</option>'); });
            sel.trigger('change');
            if(data.tujuan) $('#tempat_tujuan').val(data.tujuan.kota_tujuan);
            if(data.tanggal_berangkat) $('#tgl_berangkat').val(data.tanggal_berangkat);
            if(data.tanggal_kembali) $('#tgl_kembali').val(data.tanggal_kembali);
            if(data.lama_hari) $('#lama_hari').val(data.lama_hari);
        });
    });
});
document.getElementById('tgl_berangkat').addEventListener('change', hitungHari);
document.getElementById('tgl_kembali').addEventListener('change', hitungHari);
function hitungHari(){const b=document.getElementById('tgl_berangkat').value;const k=document.getElementById('tgl_kembali').value;if(b&&k){const d=Math.ceil((new Date(k)-new Date(b))/(1000*60*60*24))+1;document.getElementById('lama_hari').value=d>0?d:1;}}
</script>
@endpush
