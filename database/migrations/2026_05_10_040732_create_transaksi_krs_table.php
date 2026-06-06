<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('transaksi_krs', function (Blueprint $table) {
        $table->id();
        $table->string('nim'); 
        $table->string('kode_mk');
        $table->integer('semester_tempuh');
        $table->string('tahun_akademik');
        $table->string('status_verifikasi')->default('menunggu');
        $table->timestamp('verified_at')->nullable();
        $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
        $table->timestamps();

        // Relasi (Foreign Key)
        $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
        $table->foreign('kode_mk')->references('kode_mk')->on('mata_kuliah')->onDelete('cascade');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('transaksi_krs');
    }
};
