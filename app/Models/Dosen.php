<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';
    protected $primaryKey = 'nidn';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nidn', 'nama', 'gelar', 'spesialisasi'];

    public function jadwalPerkuliahan()
    {
        return $this->hasMany(TransaksiJadwalPerkuliahan::class, 'nidn', 'nidn');
    }
}
