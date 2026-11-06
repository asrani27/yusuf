<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifikasiSppd extends Model
{
    protected $table = 'verifikasi_sppd';

    protected $fillable = [
        'sppd_id',
        'verifikator_id',
        'tanggal_verifikasi',
        'status_verifikasi',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_verifikasi' => 'datetime',
        ];
    }

    public function sppd()
    {
        return $this->belongsTo(Sppd::class);
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verifikator_id');
    }
}
