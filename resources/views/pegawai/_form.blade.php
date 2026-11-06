<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">NIP <span class="text-red-500">*</span></label>
        <input type="text" name="nip" value="{{ old('nip', $pegawai->nip ?? '') }}" maxlength="18" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500" required>
        @error('nip')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pegawai <span class="text-red-500">*</span></label>
        <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai', $pegawai->nama_pegawai ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500" required>
        @error('nama_pegawai')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pegawai->tempat_lahir ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500" required>
        @error('tempat_lahir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', isset($pegawai) ? $pegawai->tanggal_lahir->format('Y-m-d') : '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500" required>
        @error('tanggal_lahir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
        <select name="jenis_kelamin" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500" required>
            <option value="">-- Pilih --</option>
            <option value="L" {{ old('jenis_kelamin', $pegawai->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('jenis_kelamin', $pegawai->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
        @error('jenis_kelamin')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Pangkat/Golongan <span class="text-red-500">*</span></label>
        <input type="text" name="pangkat_golongan" value="{{ old('pangkat_golongan', $pegawai->pangkat_golongan ?? '') }}" placeholder="Contoh: Penata Muda / III/a" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500" required>
        @error('pangkat_golongan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
        <input type="text" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500" required>
        @error('jabatan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Unit Kerja <span class="text-red-500">*</span></label>
        <input type="text" name="unit_kerja" value="{{ old('unit_kerja', $pegawai->unit_kerja ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500" required>
        @error('unit_kerja')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
        <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $pegawai->nomor_hp ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status Pegawai <span class="text-red-500">*</span></label>
        <select name="status_pegawai" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500" required>
            <option value="PNS" {{ old('status_pegawai', $pegawai->status_pegawai ?? '') == 'PNS' ? 'selected' : '' }}>PNS</option>
            <option value="PPPK" {{ old('status_pegawai', $pegawai->status_pegawai ?? '') == 'PPPK' ? 'selected' : '' }}>PPPK</option>
            <option value="Honorer" {{ old('status_pegawai', $pegawai->status_pegawai ?? '') == 'Honorer' ? 'selected' : '' }}>Honorer</option>
        </select>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
        <textarea name="alamat" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">{{ old('alamat', $pegawai->alamat ?? '') }}</textarea>
    </div>
    <div>
        <label class="flex items-center">
            <input type="hidden" name="is_pejabat" value="0">
            <input type="checkbox" name="is_pejabat" value="1" {{ old('is_pejabat', $pegawai->is_pejabat ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 mr-2">
            <span class="text-sm text-gray-700">Pejabat Penandatangan</span>
        </label>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor SK Pejabat</label>
        <input type="text" name="nomor_sk_pejabat" value="{{ old('nomor_sk_pejabat', $pegawai->nomor_sk_pejabat ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
    </div>
</div>
