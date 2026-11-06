<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sppd', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_sppd', 100)->unique();
            $table->foreignId('spt_id')->constrained('spt')->restrictOnDelete();
            $table->foreignId('pegawai_id')->constrained('pegawai');
            $table->string('tingkat_biaya', 50)->nullable();
            $table->string('alat_angkut', 50);
            $table->string('tempat_berangkat', 100)->default('Kuala Kapuas');
            $table->string('tempat_tujuan', 100);
            $table->date('tanggal_berangkat');
            $table->date('tanggal_kembali');
            $table->integer('lama_hari');
            $table->string('pembebanan_anggaran', 100);
            $table->text('keterangan')->nullable();
            $table->enum('status_sppd', ['draft', 'menunggu_verifikasi', 'diverifikasi', 'ditolak', 'selesai'])->default('draft');
            $table->timestamps();

            $table->index('nomor_sppd');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sppd');
    }
};
