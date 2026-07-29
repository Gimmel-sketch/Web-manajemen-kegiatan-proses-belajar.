<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\TransaksiKrs;
use App\Models\TransaksiNilaiPerkuliahan;
use App\Models\TransaksiPembayaranUkt;
use App\Services\FuzzyMahasiswaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function profile(): JsonResponse
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (! $mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan.'], 404);
        }

        $rataNilai = $mahasiswa->rata_nilai;
        $ipk = $mahasiswa->ipk;
        $sksLulus = $mahasiswa->total_sks_lulus;

        return response()->json([
            'nim' => $mahasiswa->nim,
            'nama' => $mahasiswa->nama,
            'alamat' => $mahasiswa->alamat,
            'tempat_lahir' => $mahasiswa->tempat_lahir,
            'tanggal_lahir' => $mahasiswa->tanggal_lahir,
            'jenis_kelamin' => $mahasiswa->jenis_kelamin,
            'fakultas' => $mahasiswa->fakultas,
            'prodi' => $mahasiswa->prodi,
            'angkatan' => $mahasiswa->angkatan,
            'semester' => $mahasiswa->semester,
            'email' => $mahasiswa->email,
            'no_hp' => $mahasiswa->no_hp,
            'status' => $mahasiswa->status,
            'agama' => $mahasiswa->agama,
            'nik' => $mahasiswa->nik,
            'rata_nilai' => $rataNilai,
            'ipk' => $ipk,
            'total_sks_lulus' => $sksLulus,
        ]);
    }

    public function krs(): JsonResponse
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (! $mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan.'], 404);
        }

        $krs = $mahasiswa->transaksiKrs()->with(['mataKuliah', 'nilaiPerkuliahan'])->get();

        return response()->json($krs->map(function ($item) {
            return [
                'id' => $item->id,
                'kode_mk' => $item->kode_mk,
                'nama_mk' => $item->mataKuliah?->nama_mk,
                'sks' => $item->mataKuliah?->sks,
                'semester_tempuh' => $item->semester_tempuh,
                'tahun_akademik' => $item->tahun_akademik,
                'status_verifikasi' => $item->status_verifikasi,
                'verified_at' => $item->verified_at,
                'nilai_akhir' => $item->nilaiPerkuliahan?->nilai_akhir,
                'nilai_huruf' => $item->nilaiPerkuliahan?->nilai_huruf,
            ];
        }));
    }

    public function jadwal(): JsonResponse
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (! $mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan.'], 404);
        }

        $kodeMkList = $mahasiswa->transaksiKrs()->pluck('kode_mk');

        $jadwal = \App\Models\TransaksiJadwalPerkuliahan::with(['mataKuliah', 'dosen', 'ruangan'])
            ->whereIn('kode_mk', $kodeMkList)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return response()->json($jadwal->map(function ($item) {
            return [
                'id' => $item->id,
                'kode_mk' => $item->kode_mk,
                'nama_mk' => $item->mataKuliah?->nama_mk,
                'sks' => $item->mataKuliah?->sks,
                'dosen' => $item->dosen?->nama,
                'ruangan' => $item->ruangan?->nama_ruangan,
                'kelas' => $item->kelas,
                'hari' => $item->hari,
                'jam_mulai' => $item->jam_mulai,
                'jam_selesai' => $item->jam_selesai,
                'semester' => $item->semester,
                'tahun_akademik' => $item->tahun_akademik,
            ];
        }));
    }

    public function presensi(): JsonResponse
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (! $mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan.'], 404);
        }

        $presensi = $mahasiswa->presensiPerkuliahan()
            ->with(['jadwalPerkuliahan.mataKuliah'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json($presensi->map(function ($item) {
            return [
                'id' => $item->id,
                'kode_mk' => $item->jadwalPerkuliahan?->kode_mk,
                'nama_mk' => $item->jadwalPerkuliahan?->mataKuliah?->nama_mk,
                'tanggal' => $item->tanggal,
                'pertemuan_ke' => $item->pertemuan_ke,
                'status' => $item->status,
                'keterangan' => $item->keterangan,
            ];
        }));
    }

    public function nilai(): JsonResponse
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;

        if (! $mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan.'], 404);
        }

        $rataNilai = $mahasiswa->rata_nilai;
        $ipk = $mahasiswa->ipk;
        $sksLulus = $mahasiswa->total_sks_lulus;

        $nilai = TransaksiNilaiPerkuliahan::with(['transaksiKrs.mataKuliah'])
            ->whereHas('transaksiKrs', function ($q) use ($mahasiswa) {
                $q->where('nim', $mahasiswa->nim);
            })
            ->get();

        return response()->json([
            'ringkasan' => [
                'rata_rata_nilai' => $rataNilai,
                'ipk' => $ipk,
                'total_sks_lulus' => $sksLulus,
            ],
            'detail' => $nilai->map(function ($item) {
                return [
                    'kode_mk' => $item->transaksiKrs?->kode_mk,
                    'nama_mk' => $item->transaksiKrs?->mataKuliah?->nama_mk,
                    'sks' => $item->transaksiKrs?->mataKuliah?->sks,
                    'nilai_tugas' => $item->nilai_tugas,
                    'nilai_uts' => $item->nilai_uts,
                    'nilai_uas' => $item->nilai_uas,
                    'nilai_akhir' => $item->nilai_akhir,
                    'nilai_huruf' => $item->nilai_huruf,
                ];
            }),
        ]);
    }

    public function ukt(): JsonResponse
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (! $mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan.'], 404);
        }

        $ukt = $mahasiswa->transaksiPembayaranUkt()->orderBy('tanggal_bayar', 'desc')->get();

        return response()->json($ukt->map(function ($item) {
            return [
                'id' => $item->id,
                'tanggal_bayar' => $item->tanggal_bayar,
                'jumlah_bayar' => (float) $item->jumlah_bayar,
                'semester_dibayar' => $item->semester_dibayar,
                'metode_pembayaran' => $item->metode_pembayaran,
                'status_pembayaran' => $item->status_pembayaran,
            ];
        }));
    }

    public function peminjamanBuku(): JsonResponse
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (! $mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan.'], 404);
        }

        $peminjaman = $mahasiswa->transaksiPeminjamanBuku()
            ->with('buku')
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        return response()->json($peminjaman->map(function ($item) {
            return [
                'id' => $item->id,
                'kode_buku' => $item->kode_buku,
                'judul_buku' => $item->buku?->judul_buku,
                'tanggal_pinjam' => $item->tanggal_pinjam,
                'tanggal_tenggat' => $item->tanggal_tenggat,
                'tanggal_kembali' => $item->tanggal_kembali,
                'status_pinjam' => $item->status_pinjam,
                'denda' => (float) $item->denda,
            ];
        }));
    }

    public function evaluasi(): JsonResponse
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (! $mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan.'], 404);
        }

        $rataNilai = $mahasiswa->rata_nilai;
        $ipk = $mahasiswa->ipk;
        $sksLulus = $mahasiswa->total_sks_lulus;

        $fuzzyService = new FuzzyMahasiswaService();
        $fuzzyResult = $fuzzyService->evaluasi($rataNilai, $ipk, $sksLulus);

        $nilaiDetail = TransaksiNilaiPerkuliahan::with(['transaksiKrs.mataKuliah'])
            ->whereHas('transaksiKrs', function ($q) use ($mahasiswa) {
                $q->where('nim', $mahasiswa->nim);
            })
            ->get();

        return response()->json([
            'mahasiswa' => [
                'nama' => $mahasiswa->nama,
                'nim' => $mahasiswa->nim,
                'prodi' => $mahasiswa->prodi,
                'semester' => $mahasiswa->semester,
            ],
            'evaluasi' => $fuzzyResult,
            'nilai_detail' => $nilaiDetail->map(function ($item) {
                return [
                    'kode_mk' => $item->transaksiKrs?->kode_mk,
                    'nama_mk' => $item->transaksiKrs?->mataKuliah?->nama_mk,
                    'sks' => $item->transaksiKrs?->mataKuliah?->sks,
                    'nilai_akhir' => $item->nilai_akhir,
                    'nilai_huruf' => $item->nilai_huruf,
                ];
            }),
        ]);
    }

    public function storeKrs(Request $request): JsonResponse
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (! $mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'kode_mk' => ['required', 'string', 'exists:mata_kuliah,kode_mk'],
            'semester_tempuh' => ['required', 'integer', 'min:1'],
            'tahun_akademik' => ['required', 'string'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $exists = TransaksiKrs::where('nim', $mahasiswa->nim)
            ->where('kode_mk', $validated['kode_mk'])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Mata kuliah ini sudah ada di KRS Anda.'], 409);
        }

        $krs = TransaksiKrs::create([
            'nim' => $mahasiswa->nim,
            'kode_mk' => $validated['kode_mk'],
            'semester_tempuh' => $validated['semester_tempuh'],
            'tahun_akademik' => $validated['tahun_akademik'],
            'keterangan' => $validated['keterangan'] ?? null,
            'status_verifikasi' => 'menunggu',
        ]);

        return response()->json([
            'message' => 'KRS berhasil ditambahkan.',
            'data' => [
                'id' => $krs->id,
                'kode_mk' => $krs->kode_mk,
                'semester_tempuh' => $krs->semester_tempuh,
                'tahun_akademik' => $krs->tahun_akademik,
                'status_verifikasi' => $krs->status_verifikasi,
            ],
        ], 201);
    }

    public function storeUkt(Request $request): JsonResponse
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (! $mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan.'], 404);
        }

        $validated = $request->validate([
            'tanggal_bayar' => ['required', 'date'],
            'jumlah_bayar' => ['required', 'numeric', 'min:0'],
            'semester_dibayar' => ['required', 'integer', 'min:1'],
            'metode_pembayaran' => ['required', 'string', 'in:Transfer Bank,Virtual Account,Tunai'],
        ]);

        $ukt = TransaksiPembayaranUkt::create([
            'nim' => $mahasiswa->nim,
            'tanggal_bayar' => $validated['tanggal_bayar'],
            'jumlah_bayar' => $validated['jumlah_bayar'],
            'semester_dibayar' => $validated['semester_dibayar'],
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'status_pembayaran' => 'Lunas',
        ]);

        return response()->json([
            'message' => 'Pembayaran UKT berhasil dicatat.',
            'data' => [
                'id' => $ukt->id,
                'tanggal_bayar' => $ukt->tanggal_bayar,
                'jumlah_bayar' => (float) $ukt->jumlah_bayar,
                'semester_dibayar' => $ukt->semester_dibayar,
                'metode_pembayaran' => $ukt->metode_pembayaran,
                'status_pembayaran' => $ukt->status_pembayaran,
            ],
        ], 201);
    }

    public function mataKuliah(): JsonResponse
    {
        $list = MataKuliah::orderBy('kode_mk')->get();

        return response()->json($list->map(function ($item) {
            return [
                'kode_mk' => $item->kode_mk,
                'nama_mk' => $item->nama_mk,
                'sks' => $item->sks,
                'semester' => $item->semester,
            ];
        }));
    }
}
