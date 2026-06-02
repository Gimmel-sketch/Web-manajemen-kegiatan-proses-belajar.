<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPeminjamanBuku extends Model
{
    protected $table = 'transaksi_peminjaman_buku';

    protected $fillable = [
        'nim',
        'kode_buku',
        'tanggal_pinjam',
        'tanggal_tenggat',
        'tanggal_kembali',
        'status_pinjam',
        'denda',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_tenggat' => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'kode_buku', 'kode_buku');
    }
}
