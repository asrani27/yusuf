<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TujuanTugas extends Model
{
    use HasFactory;

    protected $table = 'tujuan_tugas';

    protected $fillable = [
        'kota_tujuan',
        'provinsi_tujuan',
        'instansi_tujuan',
        'alamat_tujuan',
    ];

    public function spt()
    {
        return $this->hasMany(Spt::class, 'tujuan_id');
    }

    public function getNamaTujuanAttribute(): string
    {
        return $this->kota_tujuan.', '.$this->provinsi_tujuan.' - '.$this->instansi_tujuan;
    }
}
