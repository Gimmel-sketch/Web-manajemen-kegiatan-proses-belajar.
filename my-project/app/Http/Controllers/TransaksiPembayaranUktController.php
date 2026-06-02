<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\TransaksiPembayaranUkt;
use Illuminate\Http\Request;

class TransaksiPembayaranUktController extends Controller
{
    public function index()
    {
        $pembayaranUkt = TransaksiPembayaranUkt::with('mahasiswa')->latest()->get();
        return view('pembayaran-ukt.index', compact('pembayaranUkt'));
    }

    public function create()
    {
        return view('pembayaran-ukt.create', $this->formData());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        TransaksiPembayaranUkt::create($data);

        return redirect()->route('pembayaran-ukt.index')->with('success', 'Data pembayaran UKT berhasil ditambahkan.');
    }

    public function edit(TransaksiPembayaranUkt $pembayaranUkt)
    {
        return view('pembayaran-ukt.edit', array_merge($this->formData(), compact('pembayaranUkt')));
    }

    public function update(Request $request, TransaksiPembayaranUkt $pembayaranUkt)
    {
        $data = $request->validate($this->rules());
        $pembayaranUkt->update($data);

        return redirect()->route('pembayaran-ukt.index')->with('success', 'Data pembayaran UKT berhasil diperbarui.');
    }

    public function destroy(TransaksiPembayaranUkt $pembayaranUkt)
    {
        $pembayaranUkt->delete();

        return redirect()->route('pembayaran-ukt.index')->with('success', 'Data pembayaran UKT berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'nim' => ['required', 'exists:mahasiswa,nim'],
            'tanggal_bayar' => ['required', 'date'],
            'jumlah_bayar' => ['required', 'numeric', 'min:0'],
            'semester_dibayar' => ['required', 'integer', 'min:1'],
            'metode_pembayaran' => ['required', 'in:Transfer Bank,Virtual Account,Tunai'],
            'status_pembayaran' => ['required', 'in:Lunas,Pending'],
        ];
    }

    private function formData(): array
    {
        return [
            'mahasiswa' => Mahasiswa::orderBy('nama')->get(),
            'metodePembayaran' => ['Transfer Bank', 'Virtual Account', 'Tunai'],
            'statusPembayaran' => ['Lunas', 'Pending'],
        ];
    }
}
