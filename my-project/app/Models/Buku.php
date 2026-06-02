<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'kode_buku';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kode_buku', 'judul_buku', 'penulis', 'stok'];

    public function transaksiPeminjamanBuku()
    {
        return $this->hasMany(TransaksiPeminjamanBuku::class, 'kode_buku', 'kode_buku');
    }
}
