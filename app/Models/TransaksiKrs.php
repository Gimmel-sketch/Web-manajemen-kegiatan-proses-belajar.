<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiKrs extends Model
{
    protected $table = 'transaksi_krs';

    protected $fillable = [
        'nim',
        'kode_mk',
        'nidn',
        'semester_tempuh',
        'tahun_akademik',
        'status_verifikasi',
        'verified_at',
        'verified_by',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
        ];
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mk', 'kode_mk');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function nilaiPerkuliahan()
    {
        return $this->hasOne(TransaksiNilaiPerkuliahan::class, 'transaksi_krs_id');
    }
}
