<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DosenController extends Controller
{
    public function index()
    {
        $dosen = Dosen::with('mataKuliah')->orderBy('nama')->get();
        return view('dosen.index', compact('dosen'));
    }

    public function create()
    {
        return view('dosen.create', $this->formData());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nidn' => ['required', 'string', 'max:20', 'unique:dosen,nidn'],
            'nama' => ['required', 'string', 'max:255'],
            'gelar' => ['required', 'string', 'max:255'],
            'spesialisasi' => ['required', 'string', 'max:255'],
            'kode_mk' => ['required', 'exists:mata_kuliah,kode_mk'],
        ]);

        Dosen::create($data);

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function edit(Dosen $dosen)
    {
        return view('dosen.edit', array_merge($this->formData(), compact('dosen')));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $data = $request->validate([
            'nidn' => ['required', 'string', 'max:20', Rule::unique('dosen', 'nidn')->ignore($dosen->nidn, 'nidn')],
            'nama' => ['required', 'string', 'max:255'],
            'gelar' => ['required', 'string', 'max:255'],
            'spesialisasi' => ['required', 'string', 'max:255'],
            'kode_mk' => ['required', 'exists:mata_kuliah,kode_mk'],
        ]);

        $dosen->update($data);

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy(Dosen $dosen)
    {
        $dosen->delete();

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil dihapus.');
    }

    private function formData(): array
    {
        return [
            'mataKuliah' => MataKuliah::orderBy('nama_mk')->get(),
        ];
    }
}
