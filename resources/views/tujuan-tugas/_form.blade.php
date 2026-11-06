<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kota Tujuan <span class="text-red-500">*</span></label>
        <input type="text" name="kota_tujuan" value="{{ old('kota_tujuan', $tujuan->kota_tujuan ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm" required>
        @error('kota_tujuan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi <span class="text-red-500">*</span></label>
        <input type="text" name="provinsi_tujuan" value="{{ old('provinsi_tujuan', $tujuan->provinsi_tujuan ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm" required>
        @error('provinsi_tujuan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Instansi Tujuan <span class="text-red-500">*</span></label>
        <input type="text" name="instansi_tujuan" value="{{ old('instansi_tujuan', $tujuan->instansi_tujuan ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm" required>
        @error('instansi_tujuan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Tujuan</label>
        <textarea name="alamat_tujuan" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm">{{ old('alamat_tujuan', $tujuan->alamat_tujuan ?? '') }}</textarea>
    </div>
</div>
