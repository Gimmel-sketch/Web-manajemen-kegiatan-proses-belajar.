<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosen', function (Blueprint $table) {
            if (Schema::hasColumn('dosen', 'kode_mk')) {
                $table->dropForeign(['kode_mk']);
                $table->dropColumn('kode_mk');
            }
            if (Schema::hasColumn('dosen', 'spesialisasi')) {
                $table->dropColumn('spesialisasi');
            }
            if (! Schema::hasColumn('dosen', 'kontak')) {
                $table->string('kontak')->nullable();
            }
            if (! Schema::hasColumn('dosen', 'status')) {
                $table->string('status')->default('aktif');
            }
        });
    }

    public function down(): void
    {
        Schema::table('dosen', function (Blueprint $table) {
            if (Schema::hasColumn('dosen', 'kontak')) {
                $table->dropColumn('kontak');
            }
            if (Schema::hasColumn('dosen', 'status')) {
                $table->dropColumn('status');
            }
            if (! Schema::hasColumn('dosen', 'spesialisasi')) {
                $table->string('spesialisasi');
            }
            if (! Schema::hasColumn('dosen', 'kode_mk')) {
                $table->string('kode_mk')->nullable()->after('spesialisasi');
                $table->foreign('kode_mk')->references('kode_mk')->on('mata_kuliah')->nullOnDelete();
            }
        });
    }
};
