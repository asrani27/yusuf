@extends('layouts.app')
@section('title', 'Buat SPT')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Buat Surat Perintah Tugas</h2>
    <a href="{{ route('spt.index') }}" class="text-sm text-blue-600 hover:underline">&larr; Kembali</a>
</div>
@if($errors->any())
<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
    <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif
<div class="bg-white rounded-xl shadow-sm p-6">
    <form method="POST" action="{{ route('spt.store') }}" id="sptForm">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor SPT <span class="text-red-500">*</span></label>
                <input type="text" name="nomor_spt" value="{{ old('nomor_spt') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pejabat Penandatangan <span class="text-red-500">*</span></label>
                <select name="pejabat_id" id="pejabat_id" class="w-full select2-pejabat" required>
                    <option value="">-- Pilih Pejabat --</option>
                    @foreach($pejabat as $p)
                    <option value="{{ $p->id }}" {{ old('pejabat_id')==$p->id?'selected':'' }}>{{ $p->nip }} - {{ $p->nama_pegawai }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan Tugas <span class="text-red-500">*</span></label>
                <select name="tujuan_id" id="tujuan_id" class="w-full select2-tujuan" required>
                    <option value="">-- Pilih Tujuan --</option>
                    @foreach($tujuan as $t)
                    <option value="{{ $t->id }}" {{ old('tujuan_id')==$t->id?'selected':'' }}>{{ $t->kota_tujuan }}, {{ $t->provinsi_tujuan }} - {{ $t->instansi_tujuan }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Transportasi <span class="text-red-500">*</span></label>
                <select name="transportasi" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm" required>
                    <option value="">-- Pilih --</option>
                    <option value="Darat" {{ old('transportasi')=='Darat'?'selected':'' }}>Darat</option>
                    <option value="Udara" {{ old('transportasi')=='Udara'?'selected':'' }}>Udara</option>
                    <option value="Air" {{ old('transportasi')=='Air'?'selected':'' }}>Air</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berangkat <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_berangkat" id="tgl_berangkat" value="{{ old('tanggal_berangkat') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_kembali" id="tgl_kembali" value="{{ old('tanggal_kembali') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lama Hari</label>
                <input type="number" name="lama_hari" id="lama_hari" value="{{ old('lama_hari') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm bg-gray-50" readonly required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dasar Penugasan</label>
                <textarea name="dasar_penugasan" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm">{{ old('dasar_penugasan') }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Maksud Perjalanan <span class="text-red-500">*</span></label>
                <textarea name="maksud_perjalanan" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm" required>{{ old('maksud_perjalanan') }}</textarea>
            </div>
        </div>
        <div class="border-t pt-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Pegawai yang Ditugaskan</h3>
                <button type="button" onclick="addPengikut()" class="bg-green-600 text-white px-3 py-1.5 rounded-lg text-sm hover:bg-green-700">+ Tambah Pegawai</button>
            </div>
            <div id="pengikut-container">
                <div class="pengikut-row flex gap-4 items-end mb-3">
                    <div class="flex-1">
                        <label class="block text-xs text-gray-500 mb-1">Pegawai</label>
                        <select name="pengikut[0][pegawai_id]" class="w-full select2-pegawai" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawai as $p)
                            <option value="{{ $p->id }}">{{ $p->nip }} - {{ $p->nama_pegawai }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-48">
                        <label class="block text-xs text-gray-500 mb-1">Peran</label>
                        <input type="text" name="pengikut[0][peran_tugas]" value="Ketua Tim" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required>
                    </div>
                    <button type="button" onclick="this.closest(\'.pengikut-row\').remove()" class="text-red-500 hover:text-red-700 pb-2">&times;</button>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700">Simpan SPT</button>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
let pengikutIndex = 1;
// Store original options HTML before Select2 initialization to avoid data-select2-id conflicts
let pegawaiOptionsHtml = '';
function addPengikut() {
    const container = document.getElementById('pengikut-container');
    const html = `<div class="pengikut-row flex gap-4 items-end mb-3">
        <div class="flex-1"><label class="block text-xs text-gray-500 mb-1">Pegawai</label>
        <select name="pengikut[${pengikutIndex}][pegawai_id]" class="w-full select2-pegawai-dynamic" required>${pegawaiOptionsHtml}</select></div>
        <div class="w-48"><label class="block text-xs text-gray-500 mb-1">Peran</label>
        <input type="text" name="pengikut[${pengikutIndex}][peran_tugas]" value="Anggota" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm" required></div>
        <button type="button" onclick="this.closest('.pengikut-row').remove()" class="text-red-500 hover:text-red-700 pb-2">&times;</button></div>`;
    container.insertAdjacentHTML('beforeend', html);
    $(container).find('.select2-pegawai-dynamic').last().select2({width:'100%',placeholder:'-- Pilih Pegawai --'});
    pengikutIndex++;
}
$(document).ready(function(){
    // Capture clean options HTML before Select2 adds data-select2-id attributes
    pegawaiOptionsHtml = document.querySelector('.select2-pegawai').innerHTML;

    $('.select2-pejabat').select2({width:'100%',placeholder:'-- Pilih Pejabat --'});
    $('.select2-tujuan').select2({width:'100%',placeholder:'-- Pilih Tujuan --'});
    $('.select2-pegawai').select2({width:'100%',placeholder:'-- Pilih Pegawai --'});
});
document.getElementById('tgl_berangkat').addEventListener('change', hitungHari);
document.getElementById('tgl_kembali').addEventListener('change', hitungHari);
function hitungHari(){
    const b = document.getElementById('tgl_berangkat').value;
    const k = document.getElementById('tgl_kembali').value;
    if(b && k){
        const diff = Math.ceil((new Date(k) - new Date(b))/(1000*60*60*24))+1;
        document.getElementById('lama_hari').value = diff > 0 ? diff : 1;
    }
}
</script>
@endpush
