<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiNilaiPerkuliahan extends Model
{
    protected $table = 'transaksi_nilai_perkuliahan';

    protected $fillable = [
        'transaksi_krs_id',
        'nilai_tugas',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir',
        'nilai_huruf',
        'keterangan',
    ];

    public function transaksiKrs()
    {
        return $this->belongsTo(TransaksiKrs::class, 'transaksi_krs_id');
    }
}
