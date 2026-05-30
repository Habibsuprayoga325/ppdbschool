<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran_peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('identitas_siswa_id')->constrained('identitas_siswa')->onDelete('cascade');
            $table->foreignId('administrasi_item_id')->constrained('administrasi_items')->onDelete('cascade');
            $table->string('payment_code', 50);
            $table->string('bukti_bayar');
            $table->text('catatan')->nullable();
            $table->enum('status', ['menunggu_konfirmasi', 'lunas', 'ditolak'])->default('menunggu_konfirmasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran_peserta');
    }
};
