<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DosenController extends Controller
{
    public function index()
    {
        $this->authorizeAction('dosen', 'view', 'Anda tidak memiliki akses untuk melihat data dosen.');
        $dosen = Dosen::orderBy('nama')->get();
        return view('dosen.index', compact('dosen'));
    }

    public function create()
    {
        $this->authorizeAction('dosen', 'create', 'Anda tidak memiliki akses untuk menambah data dosen.');
        return view('dosen.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAction('dosen', 'create', 'Anda tidak memiliki akses untuk menambah data dosen.');
        $data = $request->validate([
            'nidn' => ['required', 'string', 'max:20', 'unique:dosen,nidn'],
            'nama' => ['required', 'string', 'max:255'],
            'gelar' => ['required', 'string', 'max:255'],
            'kontak' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:aktif,non-aktif'],
        ]);

        Dosen::create($data);

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function edit(Dosen $dosen)
    {
        $this->authorizeAction('dosen', 'update', 'Anda tidak memiliki akses untuk mengedit data dosen.');
        return view('dosen.edit', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $this->authorizeAction('dosen', 'update', 'Anda tidak memiliki akses untuk mengedit data dosen.');
        $data = $request->validate([
            'nidn' => ['required', 'string', 'max:20', Rule::unique('dosen', 'nidn')->ignore($dosen->nidn, 'nidn')],
            'nama' => ['required', 'string', 'max:255'],
            'gelar' => ['required', 'string', 'max:255'],
            'kontak' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:aktif,non-aktif'],
        ]);

        $dosen->update($data);

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen)
    {
        $this->authorizeAction('dosen', 'delete', 'Anda tidak memiliki akses untuk menghapus data dosen.');
        $dosen->delete();

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil dihapus.');
    }
}
