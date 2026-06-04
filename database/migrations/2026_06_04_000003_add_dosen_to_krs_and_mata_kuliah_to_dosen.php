<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosen', function (Blueprint $table) {
            if (! Schema::hasColumn('dosen', 'kode_mk')) {
                $table->string('kode_mk')->nullable()->after('spesialisasi');
                $table->foreign('kode_mk')->references('kode_mk')->on('mata_kuliah')->nullOnDelete();
            }
        });

        Schema::table('transaksi_krs', function (Blueprint $table) {
            if (! Schema::hasColumn('transaksi_krs', 'nidn')) {
                $table->string('nidn')->nullable()->after('kode_mk');
                $table->foreign('nidn')->references('nidn')->on('dosen')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_krs', function (Blueprint $table) {
            if (Schema::hasColumn('transaksi_krs', 'nidn')) {
                $table->dropForeign(['nidn']);
                $table->dropColumn('nidn');
            }
        });

        Schema::table('dosen', function (Blueprint $table) {
            if (Schema::hasColumn('dosen', 'kode_mk')) {
                $table->dropForeign(['kode_mk']);
                $table->dropColumn('kode_mk');
            }
        });
    }
};
