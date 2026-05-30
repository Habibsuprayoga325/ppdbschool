<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orang_tua_wali', function (Blueprint $table) {
            $table->id();
            $table->foreignId('identitas_siswa_id')->constrained('identitas_siswa')->onDelete('cascade');
            // Data Ayah
            $table->string('nama_ayah', 60);
            $table->string('status_ayah', 20)->default('Kandung');
            $table->date('tgl_lahir_ayah')->nullable();
            $table->string('telepon_ayah', 20)->nullable();
            $table->string('pendidikan_terakhir_ayah', 30)->nullable();
            $table->string('pekerjaan_ayah', 50)->nullable();
            $table->bigInteger('penghasilan_ayah')->nullable();
            $table->text('alamat_ayah')->nullable();
            // Data Ibu
            $table->string('nama_ibu', 60);
            $table->string('status_ibu', 20)->default('Kandung');
            $table->date('tgl_lahir_ibu')->nullable();
            $table->string('telepon_ibu', 20)->nullable();
            $table->string('pendidikan_terakhir_ibu', 30)->nullable();
            $table->string('pekerjaan_ibu', 50)->nullable();
            $table->bigInteger('penghasilan_ibu')->nullable();
            $table->text('alamat_ibu')->nullable();
            // Data Wali
            $table->string('nama_wali', 60)->nullable();
            $table->string('status_wali', 20)->nullable();
            $table->date('tgl_lahir_wali')->nullable();
            $table->string('telepon_wali', 20)->nullable();
            $table->string('pendidikan_terakhir_wali', 30)->nullable();
            $table->string('pekerjaan_wali', 50)->nullable();
            $table->bigInteger('penghasilan_wali')->nullable();
            $table->text('alamat_wali')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orang_tua_wali');
    }
};
