<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index()
    {
        $mataKuliah = MataKuliah::orderBy('semester')->orderBy('nama_mk')->get();
        return view('mata-kuliah.index', compact('mataKuliah'));
    }

    public function create()
    {
        return view('mata-kuliah.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_mk' => ['required', 'string', 'max:255', 'unique:mata_kuliah,kode_mk'],
            'nama_mk' => ['required', 'string', 'max:255'],
            'sks' => ['required', 'integer', 'min:1'],
            'semester' => ['required', 'integer', 'min:1'],
        ]);

        MataKuliah::create($data);

        return redirect()->route('mata-kuliah.index')->with('success', 'Data mata kuliah berhasil ditambahkan.');
    }

    public function edit(MataKuliah $mataKuliah)
    {
        return view('mata-kuliah.edit', compact('mataKuliah'));
    }

    public function update(Request $request, MataKuliah $mataKuliah)
    {
        $data = $request->validate([
            'nama_mk' => ['required', 'string', 'max:255'],
            'sks' => ['required', 'integer', 'min:1'],
            'semester' => ['required', 'integer', 'min:1'],
        ]);

        $mataKuliah->update($data);

        return redirect()->route('mata-kuliah.index')->with('success', 'Data mata kuliah berhasil diperbarui.');
    }

    public function destroy(MataKuliah $mataKuliah)
    {
        $mataKuliah->delete();

        return redirect()->route('mata-kuliah.index')->with('success', 'Data mata kuliah berhasil dihapus.');
    }
}
