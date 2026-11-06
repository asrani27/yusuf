<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';

    protected $fillable = [
        'nip',
        'nama_pegawai',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'pangkat_golongan',
        'jabatan',
        'unit_kerja',
        'nomor_hp',
        'alamat',
        'is_pejabat',
        'nomor_sk_pejabat',
        'status_pegawai',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'is_pejabat' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function sptSebagaiPejabat()
    {
        return $this->hasMany(Spt::class, 'pejabat_id');
    }

    public function sptPengikut()
    {
        return $this->belongsToMany(Spt::class, 'spt_pengikut')
            ->withPivot('peran_tugas')
            ->withTimestamps();
    }

    public function sppd()
    {
        return $this->hasMany(Sppd::class);
    }

    public function getNamaLengkapAttribute(): string
    {
        return $this->nip.' - '.$this->nama_pegawai;
    }
}
