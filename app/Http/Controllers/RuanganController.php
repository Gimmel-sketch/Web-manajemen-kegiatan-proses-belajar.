<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $this->authorizeAction('ruangan', 'view', 'Anda tidak memiliki akses untuk melihat data ruangan.');
        $ruangan = Ruangan::orderBy('nama_ruangan')->get();
        return view('ruangan.index', compact('ruangan'));
    }

    public function create()
    {
        $this->authorizeAction('ruangan', 'create', 'Anda tidak memiliki akses untuk menambah data ruangan.');
        return view('ruangan.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAction('ruangan', 'create', 'Anda tidak memiliki akses untuk menambah data ruangan.');
        $data = $request->validate([
            'nama_ruangan' => ['required', 'string', 'max:255'],
            'kapasitas' => ['required', 'integer', 'min:1'],
        ]);

        Ruangan::create($data);

        return redirect()->route('ruangan.index')->with('success', 'Data ruangan berhasil ditambahkan.');
    }

    public function edit(Ruangan $ruangan)
    {
        $this->authorizeAction('ruangan', 'update', 'Anda tidak memiliki akses untuk mengedit data ruangan.');
        return view('ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $this->authorizeAction('ruangan', 'update', 'Anda tidak memiliki akses untuk mengedit data ruangan.');
        $data = $request->validate([
            'nama_ruangan' => ['required', 'string', 'max:255'],
            'kapasitas' => ['required', 'integer', 'min:1'],
        ]);

        $ruangan->update($data);

        return redirect()->route('ruangan.index')->with('success', 'Data ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan)
    {
        $this->authorizeAction('ruangan', 'delete', 'Anda tidak memiliki akses untuk menghapus data ruangan.');
        $ruangan->delete();

        return redirect()->route('ruangan.index')->with('success', 'Data ruangan berhasil dihapus.');
    }
}
