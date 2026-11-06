<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggaranSppd extends Model
{
    protected $table = 'anggaran_sppd';

    protected $fillable = [
        'sppd_id',
        'uang_harian',
        'biaya_transportasi',
        'biaya_penginapan',
        'biaya_taksi',
        'biaya_representasi',
        'biaya_lainnya',
        'total_biaya',
        'sumber_dana',
        'kode_rekening',
        'tahun_anggaran',
    ];

    protected function casts(): array
    {
        return [
            'uang_harian' => 'decimal:2',
            'biaya_transportasi' => 'decimal:2',
            'biaya_penginapan' => 'decimal:2',
            'biaya_taksi' => 'decimal:2',
            'biaya_representasi' => 'decimal:2',
            'biaya_lainnya' => 'decimal:2',
            'total_biaya' => 'decimal:2',
        ];
    }

    public function sppd()
    {
        return $this->belongsTo(Sppd::class);
    }

    public function hitungTotal(): float
    {
        return $this->uang_harian
            + $this->biaya_transportasi
            + $this->biaya_penginapan
            + $this->biaya_taksi
            + $this->biaya_representasi
            + $this->biaya_lainnya;
    }
}
