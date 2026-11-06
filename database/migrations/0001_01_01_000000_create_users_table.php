<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 18)->unique();
            $table->string('nama_pegawai', 100);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('pangkat_golongan', 50);
            $table->string('jabatan', 100);
            $table->string('unit_kerja', 100);
            $table->string('nomor_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->boolean('is_pejabat')->default(false);
            $table->string('nomor_sk_pejabat', 100)->nullable();
            $table->enum('status_pegawai', ['PNS', 'PPPK', 'Honorer'])->default('PNS');
            $table->timestamps();

            $table->index('nip');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->nullable()->constrained('pegawai')->nullOnDelete();
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->enum('role', ['admin', 'pejabat', 'verifikator', 'pegawai']);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('pegawai');
    }
};
