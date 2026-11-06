<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifikasi_sppd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sppd_id')->constrained('sppd')->cascadeOnDelete();
            $table->foreignId('verifikator_id')->constrained('users');
            $table->timestamp('tanggal_verifikasi');
            $table->enum('status_verifikasi', ['disetujui', 'perbaikan', 'ditolak']);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasi_sppd');
    }
};
