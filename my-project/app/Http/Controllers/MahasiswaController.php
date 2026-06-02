<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return view('Data-mahasiswa', compact('mahasiswa'));
    }

    public function create()
    {
        return view('Create-mahasiswa');
    }

    public function store(Request $request)
    {
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
        $mahasiswa = Mahasiswa::findOrFail($nim);
        return view('edit-mahasiswa', compact('mahasiswa'));
    }

    public function update(Request $request, $nim)
    {
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
        $mahasiswa = Mahasiswa::findOrFail($nim);
        $mahasiswa->delete();

        return redirect()->route('Data-mahasiswa');
    }
}