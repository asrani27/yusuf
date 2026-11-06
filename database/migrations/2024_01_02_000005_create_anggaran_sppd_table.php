<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggaran_sppd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sppd_id')->unique()->constrained('sppd')->cascadeOnDelete();
            $table->decimal('uang_harian', 15, 2)->default(0);
            $table->decimal('biaya_transportasi', 15, 2)->default(0);
            $table->decimal('biaya_penginapan', 15, 2)->default(0);
            $table->decimal('biaya_taksi', 15, 2)->default(0);
            $table->decimal('biaya_representasi', 15, 2)->default(0);
            $table->decimal('biaya_lainnya', 15, 2)->default(0);
            $table->decimal('total_biaya', 15, 2)->default(0);
            $table->string('sumber_dana', 50)->default('DPA SKPD DISKOMINFOSANTIK');
            $table->string('kode_rekening', 50);
            $table->year('tahun_anggaran');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggaran_sppd');
    }
};
