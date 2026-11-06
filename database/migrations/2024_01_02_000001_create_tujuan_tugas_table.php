<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tujuan_tugas', function (Blueprint $table) {
            $table->id();
            $table->string('kota_tujuan', 50);
            $table->string('provinsi_tujuan', 50);
            $table->string('instansi_tujuan', 150);
            $table->text('alamat_tujuan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tujuan_tugas');
    }
};
