<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'pegawai_id' => 1,
            'username' => 'admin',
            'email' => 'admin@diskominfosantik.go.id',
            'password' => 'password123',
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        User::create([
            'pegawai_id' => 2,
            'username' => 'verifikator',
            'email' => 'verifikator@diskominfosantik.go.id',
            'password' => 'password123',
            'role' => 'verifikator',
            'status' => 'aktif',
        ]);

        User::create([
            'pegawai_id' => 1,
            'username' => 'pejabat',
            'email' => 'pejabat@diskominfosantik.go.id',
            'password' => 'password123',
            'role' => 'pejabat',
            'status' => 'aktif',
        ]);

        User::create([
            'pegawai_id' => 4,
            'username' => 'pegawai',
            'email' => 'pegawai@diskominfosantik.go.id',
            'password' => 'password123',
            'role' => 'pegawai',
            'status' => 'aktif',
        ]);
    }
}
