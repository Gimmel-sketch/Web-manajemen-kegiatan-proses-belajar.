<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nim', 'nama', 'alamat', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'fakultas', 
            'prodi', 'angkatan', 'email', 'no_hp', 'semester', 
            'status', 'agama', 'nik'];

    public function transaksiKrs()
    {
        return $this->hasMany(TransaksiKrs::class, 'nim', 'nim');
    }

    public function transaksiPembayaranUkt()
    {
        return $this->hasMany(TransaksiPembayaranUkt::class, 'nim', 'nim');
    }

    public function transaksiPeminjamanBuku()
    {
        return $this->hasMany(TransaksiPeminjamanBuku::class, 'nim', 'nim');
    }

    public function presensiPerkuliahan()
    {
        return $this->hasMany(TransaksiPresensiPerkuliahan::class, 'nim', 'nim');
    }

    public function nilaiPerkuliahan()
    {
        return $this->hasManyThrough(
            TransaksiNilaiPerkuliahan::class,
            TransaksiKrs::class,
            'nim',
            'transaksi_krs_id',
            'nim',
            'id'
        );
    }

    public function getRataNilaiAttribute(): float
    {
        $nilai = TransaksiNilaiPerkuliahan::select('transaksi_nilai_perkuliahan.nilai_akhir')
            ->join('transaksi_krs', 'transaksi_nilai_perkuliahan.transaksi_krs_id', '=', 'transaksi_krs.id')
            ->where('transaksi_krs.nim', $this->nim)
            ->whereNotNull('transaksi_nilai_perkuliahan.nilai_akhir')
            ->pluck('nilai_akhir');
        if ($nilai->isEmpty()) return 0;
        return round($nilai->avg(), 2);
    }

    public function getIpkAttribute(): float
    {
        $nilai = TransaksiNilaiPerkuliahan::join('transaksi_krs', 'transaksi_nilai_perkuliahan.transaksi_krs_id', '=', 'transaksi_krs.id')
            ->join('mata_kuliah', 'transaksi_krs.kode_mk', '=', 'mata_kuliah.kode_mk')
            ->where('transaksi_krs.nim', $this->nim)
            ->whereNotNull('transaksi_nilai_perkuliahan.nilai_akhir')
            ->selectRaw('SUM(mata_kuliah.sks * CASE
                WHEN transaksi_nilai_perkuliahan.nilai_akhir >= 80 THEN 4.0
                WHEN transaksi_nilai_perkuliahan.nilai_akhir >= 65 THEN 3.0
                WHEN transaksi_nilai_perkuliahan.nilai_akhir >= 50 THEN 2.0
                WHEN transaksi_nilai_perkuliahan.nilai_akhir >= 35 THEN 1.0
                ELSE 0
            END) as total_bobot, SUM(mata_kuliah.sks) as total_sks')
            ->first();

        if (!$nilai || $nilai->total_sks == 0) return 0;
        return round($nilai->total_bobot / $nilai->total_sks, 2);
    }

    public function getTotalSksLulusAttribute(): int
    {
        return (int) TransaksiNilaiPerkuliahan::join('transaksi_krs', 'transaksi_nilai_perkuliahan.transaksi_krs_id', '=', 'transaksi_krs.id')
            ->join('mata_kuliah', 'transaksi_krs.kode_mk', '=', 'mata_kuliah.kode_mk')
            ->where('transaksi_krs.nim', $this->nim)
            ->where('transaksi_nilai_perkuliahan.nilai_akhir', '>=', 50)
            ->sum('mata_kuliah.sks');
    }
}
