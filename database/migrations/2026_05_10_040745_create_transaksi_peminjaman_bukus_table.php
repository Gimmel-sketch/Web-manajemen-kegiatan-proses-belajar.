<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_peminjaman_buku', function (Blueprint $table) {
        $table->id();
        $table->string('nim');
        $table->string('kode_buku');
        $table->date('tanggal_pinjam');
        $table->date('tanggal_tenggat');
        $table->date('tanggal_kembali')->nullable();
        $table->enum('status_pinjam', ['Dipinjam', 'Dikembalikan', 'Terlambat'])->default('Dipinjam');
        $table->integer('denda')->nullable();
        $table->timestamps();

        $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
        $table->foreign('kode_buku')->references('kode_buku')->on('buku')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('transaksi_peminjaman_buku');
    }
};
