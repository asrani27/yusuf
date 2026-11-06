<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'pegawai_id',
        'username',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function verifikasiSppd()
    {
        return $this->hasMany(VerifikasiSppd::class, 'verifikator_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPejabat(): bool
    {
        return $this->role === 'pejabat';
    }

    public function isVerifikator(): bool
    {
        return $this->role === 'verifikator';
    }

    public function isPegawai(): bool
    {
        return $this->role === 'pegawai';
    }

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }
}
