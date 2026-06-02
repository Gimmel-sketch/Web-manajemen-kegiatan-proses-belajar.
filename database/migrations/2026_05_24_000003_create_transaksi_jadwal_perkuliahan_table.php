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
        Schema::create('transaksi_jadwal_perkuliahan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mk');
            $table->string('nidn');
            $table->foreignId('ruangan_id')->constrained('ruangan')->onDelete('cascade');
            $table->string('kelas');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('semester');
            $table->string('tahun_akademik');
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();

            $table->foreign('kode_mk')->references('kode_mk')->on('mata_kuliah')->onDelete('cascade');
            $table->foreign('nidn')->references('nidn')->on('dosen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_jadwal_perkuliahan');
    }
};
