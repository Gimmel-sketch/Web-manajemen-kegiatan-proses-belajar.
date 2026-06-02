<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/MataKuliah.php

class MataKuliah extends Model
{
    protected $table = 'mata_kuliah';
    protected $primaryKey = 'kode_mk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kode_mk', 'nama_mk', 'sks', 'semester'];

    public function transaksiKrs()
    {
        return $this->hasMany(TransaksiKrs::class, 'kode_mk', 'kode_mk');
    }

    public function jadwalPerkuliahan()
    {
        return $this->hasMany(TransaksiJadwalPerkuliahan::class, 'kode_mk', 'kode_mk');
    }
}
