<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi_krs', function (Blueprint $table) {
            if (! Schema::hasColumn('transaksi_krs', 'status_verifikasi')) {
                $table->string('status_verifikasi')->default('menunggu')->after('tahun_akademik');
            }

            if (! Schema::hasColumn('transaksi_krs', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('status_verifikasi');
            }

            if (! Schema::hasColumn('transaksi_krs', 'verified_by')) {
                $table->foreignId('verified_by')->nullable()->after('verified_at')->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_krs', function (Blueprint $table) {
            if (Schema::hasColumn('transaksi_krs', 'verified_by')) {
                $table->dropConstrainedForeignId('verified_by');
            }

            if (Schema::hasColumn('transaksi_krs', 'verified_at')) {
                $table->dropColumn('verified_at');
            }

            if (Schema::hasColumn('transaksi_krs', 'status_verifikasi')) {
                $table->dropColumn('status_verifikasi');
            }
        });
    }
};
