<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nim', 'nama', 'alamat', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'fakultas', 
            'prodi', 'angkatan', 'email', 'no_hp', 'semester', 
            'status', 'agama', 'nik'];

    public function transaksiKrs()
    {
        return $this->hasMany(TransaksiKrs::class, 'nim', 'nim');
    }

    public function transaksiPembayaranUkt()
    {
        return $this->hasMany(TransaksiPembayaranUkt::class, 'nim', 'nim');
    }

    public function transaksiPeminjamanBuku()
    {
        return $this->hasMany(TransaksiPeminjamanBuku::class, 'nim', 'nim');
    }
}
