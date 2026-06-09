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
        $this->authorizeAction('peminjaman_buku', 'view', 'Anda tidak memiliki akses untuk melihat data peminjaman buku.');

        $peminjamanBuku = TransaksiPeminjamanBuku::with(['mahasiswa', 'buku'])->latest()->get();
        return view('peminjaman-buku.index', compact('peminjamanBuku'));
    }

    public function create()
    {
        $this->authorizeAction('peminjaman_buku', 'create', 'Anda tidak memiliki akses untuk menambah peminjaman buku.');

        return view('peminjaman-buku.create', $this->formData());
    }

    public function store(Request $request)
    {
        $this->authorizeAction('peminjaman_buku', 'create', 'Anda tidak memiliki akses untuk menambah peminjaman buku.');

        $data = $request->validate($this->rules());

        TransaksiPeminjamanBuku::create($data);

        return redirect()->route('peminjaman-buku.index')->with('success', 'Data peminjaman buku berhasil ditambahkan.');
    }

    public function edit(TransaksiPeminjamanBuku $peminjamanBuku)
    {
        $this->authorizeAction('peminjaman_buku', 'update', 'Anda tidak memiliki akses untuk mengedit peminjaman buku.');

        return view('peminjaman-buku.edit', array_merge($this->formData(), compact('peminjamanBuku')));
    }

    public function update(Request $request, TransaksiPeminjamanBuku $peminjamanBuku)
    {
        $this->authorizeAction('peminjaman_buku', 'update', 'Anda tidak memiliki akses untuk mengedit peminjaman buku.');

        $data = $request->validate($this->rules());
        $peminjamanBuku->update($data);

        return redirect()->route('peminjaman-buku.index')->with('success', 'Data peminjaman buku berhasil diperbarui.');
    }

    public function destroy(TransaksiPeminjamanBuku $peminjamanBuku)
    {
        $this->authorizeAction('peminjaman_buku', 'delete', 'Anda tidak memiliki akses untuk menghapus peminjaman buku.');

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
