<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('transaksi_pembayaran_ukt', function (Blueprint $table) {
        $table->id();
        $table->string('nim');
        $table->dateTime('tanggal_bayar');
        $table->decimal('jumlah_bayar', 15, 2);
        $table->integer('semester_dibayar');
        $table->enum('metode_pembayaran', ['Transfer Bank', 'Virtual Account', 'Tunai']);
        $table->enum('status_pembayaran', ['Lunas', 'Pending'])->default('Pending');
        $table->timestamps();

        $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('transaksi_pembayaran_ukt');
    }
};
