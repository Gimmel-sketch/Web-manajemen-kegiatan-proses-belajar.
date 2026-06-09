<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $this->authorizeAction('buku', 'view', 'Anda tidak memiliki akses untuk melihat data buku.');
        $buku = Buku::orderBy('judul_buku')->get();
        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        $this->authorizeAction('buku', 'create', 'Anda tidak memiliki akses untuk menambah data buku.');
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAction('buku', 'create', 'Anda tidak memiliki akses untuk menambah data buku.');
        $data = $request->validate([
            'kode_buku' => ['required', 'string', 'max:255', 'unique:buku,kode_buku'],
            'judul_buku' => ['required', 'string', 'max:255'],
            'penulis' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        Buku::create($data);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        $this->authorizeAction('buku', 'update', 'Anda tidak memiliki akses untuk mengedit data buku.');
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $this->authorizeAction('buku', 'update', 'Anda tidak memiliki akses untuk mengedit data buku.');
        $data = $request->validate([
            'judul_buku' => ['required', 'string', 'max:255'],
            'penulis' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        $buku->update($data);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        $this->authorizeAction('buku', 'delete', 'Anda tidak memiliki akses untuk menghapus data buku.');
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil dihapus.');
    }
}
