<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('identitas_siswa', function (Blueprint $table) {
            $table->string('no_kk', 255)->change();
            $table->string('foto_akta', 255)->nullable()->after('foto_siswa');
        });
    }

    public function down(): void
    {
        Schema::table('identitas_siswa', function (Blueprint $table) {
            $table->string('no_kk', 20)->change();
            $table->dropColumn('foto_akta');
        });
    }
};
