<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Mahasiswa;
use App\Models\TransaksiPeminjamanBuku;
use Illuminate\Http\Request;

class TransaksiPeminjamanBukuController extends Controller
{
    public function index()
    {
        $peminjamanBuku = TransaksiPeminjamanBuku::with(['mahasiswa', 'buku'])->latest()->get();
        return view('peminjaman-buku.index', compact('peminjamanBuku'));
    }

    public function create()
    {
        return view('peminjaman-buku.create', $this->formData());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        TransaksiPeminjamanBuku::create($data);

        return redirect()->route('peminjaman-buku.index')->with('success', 'Data peminjaman buku berhasil ditambahkan.');
    }

    public function edit(TransaksiPeminjamanBuku $peminjamanBuku)
    {
        return view('peminjaman-buku.edit', array_merge($this->formData(), compact('peminjamanBuku')));
    }

    public function update(Request $request, TransaksiPeminjamanBuku $peminjamanBuku)
    {
        $data = $request->validate($this->rules());
        $peminjamanBuku->update($data);

        return redirect()->route('peminjaman-buku.index')->with('success', 'Data peminjaman buku berhasil diperbarui.');
    }

    public function destroy(TransaksiPeminjamanBuku $peminjamanBuku)
    {
        $peminjamanBuku->delete();

        return redirect()->route('peminjaman-buku.index')->with('success', 'Data peminjaman buku berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'nim' => ['required', 'exists:mahasiswa,nim'],
            'kode_buku' => ['required', 'exists:buku,kode_buku'],
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_tenggat' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
            'tanggal_kembali' => ['nullable', 'date', 'after_or_equal:tanggal_pinjam'],
            'status_pinjam' => ['required', 'in:Dipinjam,Dikembalikan,Terlambat'],
            'denda' => ['nullable', 'integer', 'min:0'],
        ];
    }

    private function formData(): array
    {
        return [
            'mahasiswa' => Mahasiswa::orderBy('nama')->get(),
            'buku' => Buku::orderBy('judul_buku')->get(),
            'statusPinjam' => ['Dipinjam', 'Dikembalikan', 'Terlambat'],
        ];
    }
}
