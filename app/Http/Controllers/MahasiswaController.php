<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\TransaksiNilaiPerkuliahan;
use App\Services\FuzzyMahasiswaService;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    protected FuzzyMahasiswaService $fuzzyMahasiswa;

    public function __construct()
    {
        $this->fuzzyMahasiswa = new FuzzyMahasiswaService();
    }

    public function index()
    {
        $this->authorizeAction('mahasiswa', 'view', 'Anda tidak memiliki akses untuk melihat data mahasiswa.');
        $mahasiswa = Mahasiswa::with('nilaiPerkuliahan')->get();
        return view('Data-mahasiswa', compact('mahasiswa'));
    }

    public function evaluasi($nim)
    {
        $this->authorizeAction('mahasiswa', 'view', 'Anda tidak memiliki akses untuk melihat data mahasiswa.');
        $mahasiswa = Mahasiswa::with(['transaksiKrs.mataKuliah', 'nilaiPerkuliahan'])->findOrFail($nim);

        $rataNilai = $mahasiswa->rata_nilai;
        $ipk = $mahasiswa->ipk;
        $sksLulus = $mahasiswa->total_sks_lulus;

        $fuzzyResult = $this->fuzzyMahasiswa->evaluasi($rataNilai, $ipk, $sksLulus);

        $nilaiDetail = TransaksiNilaiPerkuliahan::with(['transaksiKrs.mataKuliah'])
            ->whereHas('transaksiKrs', function ($q) use ($nim) {
                $q->where('nim', $nim);
            })
            ->get();

        return view('mahasiswa.evaluasi', compact('mahasiswa', 'fuzzyResult', 'rataNilai', 'ipk', 'sksLulus', 'nilaiDetail'));
    }

    public function create()
    {
        $this->authorizeAction('mahasiswa', 'create', 'Anda tidak memiliki akses untuk menambah data mahasiswa.');
        return view('Create-mahasiswa');
    }

    public function store(Request $request)
    {
        $this->authorizeAction('mahasiswa', 'create', 'Anda tidak memiliki akses untuk menambah data mahasiswa.');
        Mahasiswa::create([
            'nim'    => $request->nim,
            'nama'   => $request->nama,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'fakultas' => $request->fakultas,
            'prodi' => $request->prodi,
            'angkatan' => $request->angkatan,
            'semester' => $request->semester,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'status' => $request->status,
            'agama' => $request->agama,
            'nik' => $request->nik,
        ]);

        return redirect()->route('Data-mahasiswa');
    }

    public function show($id)
    {
        //
    }

    public function edit($nim)
    {
        $this->authorizeAction('mahasiswa', 'update', 'Anda tidak memiliki akses untuk mengedit data mahasiswa.');
        $mahasiswa = Mahasiswa::findOrFail($nim);
        return view('edit-mahasiswa', compact('mahasiswa'));
    }

    public function update(Request $request, $nim)
    {
        $this->authorizeAction('mahasiswa', 'update', 'Anda tidak memiliki akses untuk mengedit data mahasiswa.');
        $mahasiswa = Mahasiswa::findOrFail($nim);

        $mahasiswa->update([
            'nim'    => $request->nim,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'fakultas' => $request->fakultas,
            'prodi' => $request->prodi,
            'angkatan' => $request->angkatan,
            'semester' => $request->semester,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'status' => $request->status,
            'agama' => $request->agama,
            'nik' => $request->nik,
        ]);

        return redirect()->route('Data-mahasiswa');
    }

    public function destroy($nim)
    {
        $this->authorizeAction('mahasiswa', 'delete', 'Anda tidak memiliki akses untuk menghapus data mahasiswa.');
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $mahasiswa->delete();

        return redirect()->route('Data-mahasiswa');
    }
}