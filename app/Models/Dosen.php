<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';
    protected $primaryKey = 'nidn';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nidn', 'nama', 'gelar', 'spesialisasi', 'kode_mk'];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mk', 'kode_mk');
    }

    public function jadwalPerkuliahan()
    {
        return $this->hasMany(TransaksiJadwalPerkuliahan::class, 'nidn', 'nidn');
    }

    public function transaksiKrs()
    {
        return $this->hasMany(TransaksiKrs::class, 'nidn', 'nidn');
    }
}
