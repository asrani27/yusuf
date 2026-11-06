<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spt', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_spt', 100)->unique();
            $table->foreignId('pejabat_id')->constrained('pegawai');
            $table->foreignId('tujuan_id')->constrained('tujuan_tugas');
            $table->text('maksud_perjalanan');
            $table->text('dasar_penugasan')->nullable();
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
            $table->integer('lama_hari');
            $table->string('transportasi', 50);
            $table->enum('status_spt', ['draft', 'diajukan', 'disetujui', 'ditolak'])->default('draft');
            $table->timestamps();

            $table->index('nomor_spt');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spt');
    }
};
