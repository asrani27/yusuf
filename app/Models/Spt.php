<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spt extends Model
{
    use HasFactory;

    protected $table = 'spt';

    protected $fillable = [
        'nomor_spt',
        'pejabat_id',
        'tujuan_id',
        'maksud_perjalanan',
        'dasar_penugasan',
        'tanggal_berangkat',
        'tanggal_kembali',
        'lama_hari',
        'transportasi',
        'status_spt',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_berangkat' => 'date',
            'tanggal_kembali' => 'date',
        ];
    }

    public function pejabat()
    {
        return $this->belongsTo(Pegawai::class, 'pejabat_id');
    }

    public function tujuan()
    {
        return $this->belongsTo(TujuanTugas::class, 'tujuan_id');
    }

    public function pengikut()
    {
        return $this->belongsToMany(Pegawai::class, 'spt_pengikut')
            ->withPivot('peran_tugas')
            ->withTimestamps();
    }

    public function sptPengikut()
    {
        return $this->hasMany(SptPengikut::class);
    }

    public function sppd()
    {
        return $this->hasMany(Sppd::class);
    }
}
