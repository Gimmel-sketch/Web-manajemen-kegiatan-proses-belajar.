<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\TransaksiJadwalPerkuliahan;
use App\Models\TransaksiPresensiPerkuliahan;
use Illuminate\Http\Request;

class TransaksiPresensiPerkuliahanController extends Controller
{
    public function index()
    {
        $this->authorizeAction('presensi_perkuliahan', 'view', 'Anda tidak memiliki akses untuk melihat data presensi perkuliahan.');
        $presensiPerkuliahan = TransaksiPresensiPerkuliahan::with(['jadwalPerkuliahan.mataKuliah', 'mahasiswa'])
            ->latest('tanggal')
            ->get();

        $presensiPerMahasiswa = $presensiPerkuliahan->groupBy('nim');

        return view('presensi-perkuliahan.index', compact('presensiPerMahasiswa'));
    }

    public function byMahasiswa(string $nim)
    {
        $this->authorizeAction('presensi_perkuliahan', 'view', 'Anda tidak memiliki akses untuk melihat data presensi perkuliahan.');

        $mahasiswa = Mahasiswa::findOrFail($nim);

        $presensi = TransaksiPresensiPerkuliahan::with([
            'jadwalPerkuliahan.mataKuliah',
            'jadwalPerkuliahan.dosen',
        ])
            ->where('nim', $nim)
            ->latest('tanggal')
            ->get();

        return view('presensi-perkuliahan.detail', compact('mahasiswa', 'presensi'));
    }

    public function create()
    {
        $this->authorizeAction('presensi_perkuliahan', 'create', 'Anda tidak memiliki akses untuk menambah presensi perkuliahan.');
        return view('presensi-perkuliahan.create', $this->formData());
    }

    public function store(Request $request)
    {
        $this->authorizeAction('presensi_perkuliahan', 'create', 'Anda tidak memiliki akses untuk menambah presensi perkuliahan.');
        $data = $request->validate($this->rules());

        TransaksiPresensiPerkuliahan::create($data);

        return redirect()->route('presensi-perkuliahan.index')->with('success', 'Presensi perkuliahan berhasil ditambahkan.');
    }

    public function edit(TransaksiPresensiPerkuliahan $presensiPerkuliahan)
    {
        $this->authorizeAction('presensi_perkuliahan', 'update', 'Anda tidak memiliki akses untuk mengedit presensi perkuliahan.');
        return view('presensi-perkuliahan.edit', array_merge($this->formData(), [
            'presensiPerkuliahan' => $presensiPerkuliahan,
        ]));
    }

    public function update(Request $request, TransaksiPresensiPerkuliahan $presensiPerkuliahan)
    {
        $this->authorizeAction('presensi_perkuliahan', 'update', 'Anda tidak memiliki akses untuk mengedit presensi perkuliahan.');
        $data = $request->validate($this->rules());
        $presensiPerkuliahan->update($data);

        return redirect()->route('presensi-perkuliahan.index')->with('success', 'Presensi perkuliahan berhasil diperbarui.');
    }

    public function destroy(TransaksiPresensiPerkuliahan $presensiPerkuliahan)
    {
        $this->authorizeAction('presensi_perkuliahan', 'delete', 'Anda tidak memiliki akses untuk menghapus presensi perkuliahan.');
        $presensiPerkuliahan->delete();

        return redirect()->route('presensi-perkuliahan.index')->with('success', 'Presensi perkuliahan berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'jadwal_perkuliahan_id' => ['required', 'exists:transaksi_jadwal_perkuliahan,id'],
            'nim' => ['required', 'exists:mahasiswa,nim'],
            'tanggal' => ['required', 'date'],
            'pertemuan_ke' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:Hadir,Izin,Sakit,Alpa'],
            'keterangan' => ['nullable', 'string'],
        ];
    }

    private function formData(): array
    {
        return [
            'jadwalPerkuliahan' => TransaksiJadwalPerkuliahan::with('mataKuliah')->latest()->get(),
            'mahasiswa' => Mahasiswa::orderBy('nama')->get(),
            'statusList' => ['Hadir', 'Izin', 'Sakit', 'Alpa'],
        ];
    }
}
