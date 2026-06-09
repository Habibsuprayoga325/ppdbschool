<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayaran_peserta', function (Blueprint $table) {
            if (Schema::hasColumn('pembayaran_peserta', 'bukti_bayar')) {
                $table->dropColumn('bukti_bayar');
            }
            $table->string('payment_proof')->nullable()->after('payment_code');
            $table->dropColumn('status');
        });

        Schema::table('pembayaran_peserta', function (Blueprint $table) {
            $table->string('status', 30)->default('pending')->after('catatan');
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran_peserta', function (Blueprint $table) {
            if (Schema::hasColumn('pembayaran_peserta', 'payment_proof')) {
                $table->dropColumn('payment_proof');
            }
            $table->dropColumn('status');
        });

        Schema::table('pembayaran_peserta', function (Blueprint $table) {
            $table->string('bukti_bayar')->nullable()->after('payment_code');
            $table->enum('status', ['menunggu_konfirmasi', 'lunas', 'ditolak'])->default('menunggu_konfirmasi')->after('catatan');
        });
    }
};
