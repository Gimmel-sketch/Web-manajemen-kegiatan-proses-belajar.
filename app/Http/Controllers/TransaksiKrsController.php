<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\TransaksiKrs;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransaksiKrsController extends Controller
{
    public function index()
    {
        $transaksiKrs = TransaksiKrs::with(['mahasiswa', 'mataKuliah', 'dosen', 'verifier'])->latest()->get();
        return view('transaksi-krs.index', compact('transaksiKrs'));
    }

    public function create()
    {
        return view('transaksi-krs.create', $this->formData());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['status_verifikasi'] = 'menunggu';

        TransaksiKrs::create($data);

        return redirect()->route('transaksi-krs.index')->with('success', 'Data KRS berhasil ditambahkan.');
    }

    public function edit(TransaksiKrs $transaksiKr)
    {
        return view('transaksi-krs.edit', array_merge($this->formData(), [
            'transaksiKrs' => $transaksiKr,
        ]));
    }

    public function update(Request $request, TransaksiKrs $transaksiKr)
    {
        $data = $request->validate($this->rules());
        $data['status_verifikasi'] = 'menunggu';
        $data['verified_at'] = null;
        $data['verified_by'] = null;

        $transaksiKr->update($data);

        return redirect()->route('transaksi-krs.index')->with('success', 'Data KRS berhasil diperbarui.');
    }

    public function verify(TransaksiKrs $transaksiKr)
    {
        $transaksiKr->update([
            'status_verifikasi' => 'terverifikasi',
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

        return redirect()->route('transaksi-krs.index')->with('success', 'Data KRS berhasil diverifikasi.');
    }

    public function unverify(TransaksiKrs $transaksiKr)
    {
        $transaksiKr->update([
            'status_verifikasi' => 'menunggu',
            'verified_at' => null,
            'verified_by' => null,
        ]);

        return redirect()->route('transaksi-krs.index')->with('success', 'Verifikasi KRS berhasil dibatalkan.');
    }

    public function destroy(TransaksiKrs $transaksiKr)
    {
        $transaksiKr->delete();

        return redirect()->route('transaksi-krs.index')->with('success', 'Data KRS berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'nim' => ['required', 'exists:mahasiswa,nim'],
            'kode_mk' => ['required', 'exists:mata_kuliah,kode_mk'],
            'nidn' => [
                'required',
                Rule::exists('dosen', 'nidn')->where(fn ($query) => $query->where('kode_mk', request('kode_mk'))),
            ],
            'semester_tempuh' => ['required', 'integer', 'min:1'],
            'tahun_akademik' => ['required', 'string', 'max:255'],
        ];
    }

    private function formData(): array
    {
        return [
            'mahasiswa' => Mahasiswa::orderBy('nama')->get(),
            'mataKuliah' => MataKuliah::orderBy('nama_mk')->get(),
            'dosen' => Dosen::with('mataKuliah')->orderBy('nama')->get(),
        ];
    }
}
