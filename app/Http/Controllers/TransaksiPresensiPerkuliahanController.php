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
        $presensiPerkuliahan = TransaksiPresensiPerkuliahan::with(['jadwalPerkuliahan.mataKuliah', 'mahasiswa'])
            ->latest('tanggal')
            ->get();

        return view('presensi-perkuliahan.index', compact('presensiPerkuliahan'));
    }

    public function create()
    {
        return view('presensi-perkuliahan.create', $this->formData());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        TransaksiPresensiPerkuliahan::create($data);

        return redirect()->route('presensi-perkuliahan.index')->with('success', 'Presensi perkuliahan berhasil ditambahkan.');
    }

    public function edit(TransaksiPresensiPerkuliahan $presensiPerkuliahan)
    {
        return view('presensi-perkuliahan.edit', array_merge($this->formData(), [
            'presensiPerkuliahan' => $presensiPerkuliahan,
        ]));
    }

    public function update(Request $request, TransaksiPresensiPerkuliahan $presensiPerkuliahan)
    {
        $data = $request->validate($this->rules());
        $presensiPerkuliahan->update($data);

        return redirect()->route('presensi-perkuliahan.index')->with('success', 'Presensi perkuliahan berhasil diperbarui.');
    }

    public function destroy(TransaksiPresensiPerkuliahan $presensiPerkuliahan)
    {
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
