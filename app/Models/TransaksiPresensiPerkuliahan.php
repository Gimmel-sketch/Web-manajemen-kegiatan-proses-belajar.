<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPresensiPerkuliahan extends Model
{
    protected $table = 'transaksi_presensi_perkuliahan';

    protected $fillable = [
        'jadwal_perkuliahan_id',
        'nim',
        'tanggal',
        'pertemuan_ke',
        'status',
        'keterangan',
    ];

    public function jadwalPerkuliahan()
    {
        return $this->belongsTo(TransaksiJadwalPerkuliahan::class, 'jadwal_perkuliahan_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
