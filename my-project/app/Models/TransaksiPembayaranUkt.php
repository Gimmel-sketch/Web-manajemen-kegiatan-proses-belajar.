<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPembayaranUkt extends Model
{
    protected $table = 'transaksi_pembayaran_ukt';

    protected $fillable = [
        'nim',
        'tanggal_bayar',
        'jumlah_bayar',
        'semester_dibayar',
        'metode_pembayaran',
        'status_pembayaran',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
