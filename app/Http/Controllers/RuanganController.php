<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::orderBy('nama_ruangan')->get();
        return view('ruangan.index', compact('ruangan'));
    }

    public function create()
    {
        return view('ruangan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_ruangan' => ['required', 'string', 'max:255'],
            'kapasitas' => ['required', 'integer', 'min:1'],
        ]);

        Ruangan::create($data);

        return redirect()->route('ruangan.index')->with('success', 'Data ruangan berhasil ditambahkan.');
    }

    public function edit(Ruangan $ruangan)
    {
        return view('ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $data = $request->validate([
            'nama_ruangan' => ['required', 'string', 'max:255'],
            'kapasitas' => ['required', 'integer', 'min:1'],
        ]);

        $ruangan->update($data);

        return redirect()->route('ruangan.index')->with('success', 'Data ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();

        return redirect()->route('ruangan.index')->with('success', 'Data ruangan berhasil dihapus.');
    }
}
