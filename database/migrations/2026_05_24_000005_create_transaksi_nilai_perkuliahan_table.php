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
        Schema::create('transaksi_nilai_perkuliahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_krs_id')->constrained('transaksi_krs')->onDelete('cascade');
            $table->decimal('nilai_tugas', 5, 2)->nullable();
            $table->decimal('nilai_uts', 5, 2)->nullable();
            $table->decimal('nilai_uas', 5, 2)->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->string('nilai_huruf', 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique('transaksi_krs_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_nilai_perkuliahan');
    }
};
