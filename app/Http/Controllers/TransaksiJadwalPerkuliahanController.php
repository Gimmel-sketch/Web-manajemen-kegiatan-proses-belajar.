<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\TransaksiJadwalPerkuliahan;
use Illuminate\Http\Request;

class TransaksiJadwalPerkuliahanController extends Controller
{
    public function index()
    {
        $jadwalPerkuliahan = TransaksiJadwalPerkuliahan::with(['mataKuliah', 'dosen', 'ruangan', 'presensiPerkuliahan'])
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return view('jadwal-perkuliahan.index', compact('jadwalPerkuliahan'));
    }

    public function create()
    {
        return view('jadwal-perkuliahan.create', $this->formData());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        TransaksiJadwalPerkuliahan::create($data);

        return redirect()->route('jadwal-perkuliahan.index')->with('success', 'Jadwal perkuliahan berhasil ditambahkan.');
    }

    public function edit(TransaksiJadwalPerkuliahan $jadwalPerkuliahan)
    {
        return view('jadwal-perkuliahan.edit', array_merge($this->formData(), [
            'jadwalPerkuliahan' => $jadwalPerkuliahan,
        ]));
    }

    public function update(Request $request, TransaksiJadwalPerkuliahan $jadwalPerkuliahan)
    {
        $data = $request->validate($this->rules());
        $jadwalPerkuliahan->update($data);

        return redirect()->route('jadwal-perkuliahan.index')->with('success', 'Jadwal perkuliahan berhasil diperbarui.');
    }

    public function destroy(TransaksiJadwalPerkuliahan $jadwalPerkuliahan)
    {
        $jadwalPerkuliahan->delete();

        return redirect()->route('jadwal-perkuliahan.index')->with('success', 'Jadwal perkuliahan berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'kode_mk' => ['required', 'exists:mata_kuliah,kode_mk'],
            'nidn' => ['required', 'exists:dosen,nidn'],
            'ruangan_id' => ['required', 'exists:ruangan,id'],
            'kelas' => ['required', 'string', 'max:50'],
            'hari' => ['required', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'semester' => ['required', 'integer', 'min:1'],
            'tahun_akademik' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:Aktif,Tidak Aktif'],
        ];
    }

    private function formData(): array
    {
        return [
            'mataKuliah' => MataKuliah::orderBy('nama_mk')->get(),
            'dosen' => Dosen::orderBy('nama')->get(),
            'ruangan' => Ruangan::orderBy('nama_ruangan')->get(),
            'hariList' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            'statusList' => ['Aktif', 'Tidak Aktif'],
        ];
    }
}
