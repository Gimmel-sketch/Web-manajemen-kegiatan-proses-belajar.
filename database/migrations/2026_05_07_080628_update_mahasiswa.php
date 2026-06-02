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
        Schema::table('mahasiswa', function (Blueprint $table) {
        $table->string('tempat_lahir')->after('alamat');
        $table->date('tanggal_lahir')->after('tempat_lahir');
        $table->enum('jenis_kelamin', ['L', 'P'])->after('tanggal_lahir');
        $table->string('fakultas')->after('jenis_kelamin');
        $table->string('prodi')->after('fakultas');
        $table->year('angkatan')->after('prodi');
        $table->integer('semester')->default(1)->after('angkatan');
        $table->string('email')->unique()->after('semester');
        $table->string('no_hp', 15)->after('email');
        $table->enum('status', ['Aktif', 'Cuti', 'Lulus', 'DO'])->default('Aktif')->after('no_hp');
        $table->string('agama')->after('status');
        $table->string('nik', 16)->unique()->after('agama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn([
            'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'fakultas', 
            'prodi', 'angkatan', 'email', 'no_hp', 'semester', 
            'status', 'agama', 'nik'
            ]);
        });
    }
};
