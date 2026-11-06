<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sppd extends Model
{
    use HasFactory;

    protected $table = 'sppd';

    protected $fillable = [
        'nomor_sppd',
        'spt_id',
        'pegawai_id',
        'tingkat_biaya',
        'alat_angkut',
        'tempat_berangkat',
        'tempat_tujuan',
        'tanggal_berangkat',
        'tanggal_kembali',
        'lama_hari',
        'pembebanan_anggaran',
        'keterangan',
        'status_sppd',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_berangkat' => 'date',
            'tanggal_kembali' => 'date',
        ];
    }

    public function spt()
    {
        return $this->belongsTo(Spt::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function anggaran()
    {
        return $this->hasOne(AnggaranSppd::class);
    }

    public function verifikasi()
    {
        return $this->hasMany(VerifikasiSppd::class);
    }

    public function latestVerifikasi()
    {
        return $this->hasOne(VerifikasiSppd::class)->latestOfMany();
    }
}
