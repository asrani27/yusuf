<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spt_pengikut', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spt_id')->constrained('spt')->cascadeOnDelete();
            $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
            $table->string('peran_tugas', 100)->default('Anggota');
            $table->timestamps();

            $table->unique(['spt_id', 'pegawai_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spt_pengikut');
    }
};
