<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SptPengikut extends Model
{
    protected $table = 'spt_pengikut';

    protected $fillable = [
        'spt_id',
        'pegawai_id',
        'peran_tugas',
    ];

    public function spt()
    {
        return $this->belongsTo(Spt::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
