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
        Schema::create('transaksi_presensi_perkuliahan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_perkuliahan_id');
            $table->string('nim');
            $table->date('tanggal');
            $table->integer('pertemuan_ke');
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alpa']);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('jadwal_perkuliahan_id', 'presensi_jadwal_fk')
                ->references('id')
                ->on('transaksi_jadwal_perkuliahan')
                ->onDelete('cascade');
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->unique(['jadwal_perkuliahan_id', 'nim', 'pertemuan_ke'], 'presensi_jadwal_nim_pertemuan_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_presensi_perkuliahan');
    }
};
