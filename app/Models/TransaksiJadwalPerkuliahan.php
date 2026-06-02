<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiJadwalPerkuliahan extends Model
{
    protected $table = 'transaksi_jadwal_perkuliahan';

    protected $fillable = [
        'kode_mk',
        'nidn',
        'ruangan_id',
        'kelas',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'semester',
        'tahun_akademik',
        'status',
    ];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mk', 'kode_mk');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    public function presensiPerkuliahan()
    {
        return $this->hasMany(TransaksiPresensiPerkuliahan::class, 'jadwal_perkuliahan_id');
    }
}
