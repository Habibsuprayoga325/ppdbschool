<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('identitas_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 15)->unique();
            $table->string('no_kk', 20);
            $table->string('nik', 16)->unique();
            $table->string('nama_panggilan', 50);
            $table->string('nama_peserta_didik', 100);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->string('agama', 20);
            $table->string('gol_darah', 5)->nullable();
            $table->integer('tinggi_badan')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->string('suku', 30)->nullable();
            $table->string('bahasa', 30)->nullable();
            $table->string('kewarganegaraan', 20)->default('Indonesia');
            $table->string('status_anak', 20)->nullable();
            $table->tinyInteger('anak_ke')->default(1);
            $table->tinyInteger('jml_saudara')->default(0);
            $table->string('jenis_tinggal', 30)->nullable();
            $table->text('alamat_tinggal');
            $table->string('provinsi_tinggal', 50);
            $table->string('kab_kota_tinggal', 50);
            $table->string('kec_tinggal', 50);
            $table->string('kelurahan_tinggal', 50);
            $table->string('kode_pos', 10)->nullable();
            $table->integer('jarak_ke_sekolah')->nullable()->comment('dalam meter');
            $table->text('riwayat_penyakit')->nullable();
            $table->boolean('status_ortu')->default(false);
            $table->boolean('status_administrasi')->default(false);
            $table->string('tahun_ajaran', 9)->nullable()->comment('contoh: 2026/2027');
            $table->string('foto_siswa')->nullable();
            $table->string('no_pendaftaran', 20)->unique()->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('identitas_siswa');
    }
};
