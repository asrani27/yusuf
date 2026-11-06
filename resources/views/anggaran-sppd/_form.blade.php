<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Uang Harian (Rp) *</label>
        <input type="number" step="0.01" name="uang_harian" id="uang_harian" value="{{ old('uang_harian', $anggaran->uang_harian ?? 0) }}" class="w-full px-4 py-2 border rounded-lg text-sm biaya-input" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Transportasi (Rp) *</label>
        <input type="number" step="0.01" name="biaya_transportasi" id="biaya_transportasi" value="{{ old('biaya_transportasi', $anggaran->biaya_transportasi ?? 0) }}" class="w-full px-4 py-2 border rounded-lg text-sm biaya-input" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Penginapan (Rp) *</label>
        <input type="number" step="0.01" name="biaya_penginapan" id="biaya_penginapan" value="{{ old('biaya_penginapan', $anggaran->biaya_penginapan ?? 0) }}" class="w-full px-4 py-2 border rounded-lg text-sm biaya-input" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Taksi (Rp) *</label>
        <input type="number" step="0.01" name="biaya_taksi" id="biaya_taksi" value="{{ old('biaya_taksi', $anggaran->biaya_taksi ?? 0) }}" class="w-full px-4 py-2 border rounded-lg text-sm biaya-input" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Representasi (Rp) *</label>
        <input type="number" step="0.01" name="biaya_representasi" id="biaya_representasi" value="{{ old('biaya_representasi', $anggaran->biaya_representasi ?? 0) }}" class="w-full px-4 py-2 border rounded-lg text-sm biaya-input" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Lainnya (Rp) *</label>
        <input type="number" step="0.01" name="biaya_lainnya" id="biaya_lainnya" value="{{ old('biaya_lainnya', $anggaran->biaya_lainnya ?? 0) }}" class="w-full px-4 py-2 border rounded-lg text-sm biaya-input" required>
    </div>
    <div class="md:col-span-2 p-4 bg-blue-50 rounded-lg">
        <label class="block text-sm font-bold text-blue-800 mb-1">Total Biaya (Rp)</label>
        <p class="text-2xl font-bold text-blue-700" id="total_display">Rp 0</p>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Sumber Dana *</label>
        <input type="text" name="sumber_dana" value="{{ old('sumber_dana', $anggaran->sumber_dana ?? 'DPA SKPD DISKOMINFOSANTIK') }}" class="w-full px-4 py-2 border rounded-lg text-sm" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Rekening *</label>
        <input type="text" name="kode_rekening" value="{{ old('kode_rekening', $anggaran->kode_rekening ?? '') }}" placeholder="Contoh: 5.2.2.15.02" class="w-full px-4 py-2 border rounded-lg text-sm" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Anggaran *</label>
        <input type="number" name="tahun_anggaran" value="{{ old('tahun_anggaran', $anggaran->tahun_anggaran ?? date('Y')) }}" class="w-full px-4 py-2 border rounded-lg text-sm" required>
    </div>
</div>
