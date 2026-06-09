<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKrs;
use App\Models\TransaksiNilaiPerkuliahan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransaksiNilaiPerkuliahanController extends Controller
{
    public function index()
    {
        $this->authorizeAction('nilai_perkuliahan', 'view', 'Anda tidak memiliki akses untuk melihat data nilai perkuliahan.');
        $nilaiPerkuliahan = TransaksiNilaiPerkuliahan::with(['transaksiKrs.mahasiswa', 'transaksiKrs.mataKuliah'])
            ->latest()
            ->get();

        return view('nilai-perkuliahan.index', compact('nilaiPerkuliahan'));
    }

    public function create()
    {
        $this->authorizeAction('nilai_perkuliahan', 'create', 'Anda tidak memiliki akses untuk menambah nilai perkuliahan.');
        return view('nilai-perkuliahan.create', $this->formData());
    }

    public function store(Request $request)
    {
        $this->authorizeAction('nilai_perkuliahan', 'create', 'Anda tidak memiliki akses untuk menambah nilai perkuliahan.');
        $data = $request->validate($this->rules());

        TransaksiNilaiPerkuliahan::create($data);

        return redirect()->route('nilai-perkuliahan.index')->with('success', 'Nilai perkuliahan berhasil ditambahkan.');
    }

    public function edit(TransaksiNilaiPerkuliahan $nilaiPerkuliahan)
    {
        $this->authorizeAction('nilai_perkuliahan', 'update', 'Anda tidak memiliki akses untuk mengedit nilai perkuliahan.');
        return view('nilai-perkuliahan.edit', array_merge($this->formData(), [
            'nilaiPerkuliahan' => $nilaiPerkuliahan,
        ]));
    }

    public function update(Request $request, TransaksiNilaiPerkuliahan $nilaiPerkuliahan)
    {
        $this->authorizeAction('nilai_perkuliahan', 'update', 'Anda tidak memiliki akses untuk mengedit nilai perkuliahan.');
        $data = $request->validate($this->rules($nilaiPerkuliahan));
        $nilaiPerkuliahan->update($data);

        return redirect()->route('nilai-perkuliahan.index')->with('success', 'Nilai perkuliahan berhasil diperbarui.');
    }

    public function destroy(TransaksiNilaiPerkuliahan $nilaiPerkuliahan)
    {
        $this->authorizeAction('nilai_perkuliahan', 'delete', 'Anda tidak memiliki akses untuk menghapus nilai perkuliahan.');
        $nilaiPerkuliahan->delete();

        return redirect()->route('nilai-perkuliahan.index')->with('success', 'Nilai perkuliahan berhasil dihapus.');
    }

    private function rules(?TransaksiNilaiPerkuliahan $nilaiPerkuliahan = null): array
    {
        return [
            'transaksi_krs_id' => [
                'required',
                'exists:transaksi_krs,id',
                Rule::unique('transaksi_nilai_perkuliahan', 'transaksi_krs_id')->ignore($nilaiPerkuliahan?->id),
            ],
            'nilai_tugas' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_uts' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_uas' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_akhir' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'nilai_huruf' => ['nullable', 'string', 'max:2'],
            'keterangan' => ['nullable', 'string'],
        ];
    }

    private function formData(): array
    {
        return [
            'transaksiKrs' => TransaksiKrs::with(['mahasiswa', 'mataKuliah'])->latest()->get(),
        ];
    }
}
