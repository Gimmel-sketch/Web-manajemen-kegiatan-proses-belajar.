<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiKrs extends Model
{
    protected $table = 'transaksi_krs';

    protected $fillable = ['nim', 'kode_mk', 'semester_tempuh', 'tahun_akademik', 'nilai_akhir'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mk', 'kode_mk');
    }
}
