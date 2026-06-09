<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\TransaksiPembayaranUkt;
use Illuminate\Http\Request;

class TransaksiPembayaranUktController extends Controller
{
    public function index()
    {
        $this->authorizeAction('pembayaran_ukt', 'view', 'Anda tidak memiliki akses untuk melihat data pembayaran UKT.');
        $pembayaranUkt = TransaksiPembayaranUkt::with('mahasiswa')->latest()->get();
        return view('pembayaran-ukt.index', compact('pembayaranUkt'));
    }

    public function create()
    {
        $this->authorizeAction('pembayaran_ukt', 'create', 'Anda tidak memiliki akses untuk menambah data pembayaran UKT.');
        return view('pembayaran-ukt.create', $this->formData());
    }

    public function store(Request $request)
    {
        $this->authorizeAction('pembayaran_ukt', 'create', 'Anda tidak memiliki akses untuk menambah data pembayaran UKT.');
        $data = $request->validate($this->rules());

        TransaksiPembayaranUkt::create($data);

        return redirect()->route('pembayaran-ukt.index')->with('success', 'Data pembayaran UKT berhasil ditambahkan.');
    }

    public function edit(TransaksiPembayaranUkt $pembayaranUkt)
    {
        $this->authorizeAction('pembayaran_ukt', 'update', 'Anda tidak memiliki akses untuk mengedit data pembayaran UKT.');
        return view('pembayaran-ukt.edit', array_merge($this->formData(), compact('pembayaranUkt')));
    }

    public function update(Request $request, TransaksiPembayaranUkt $pembayaranUkt)
    {
        $this->authorizeAction('pembayaran_ukt', 'update', 'Anda tidak memiliki akses untuk mengedit data pembayaran UKT.');
        $data = $request->validate($this->rules());
        $pembayaranUkt->update($data);

        return redirect()->route('pembayaran-ukt.index')->with('success', 'Data pembayaran UKT berhasil diperbarui.');
    }

    public function destroy(TransaksiPembayaranUkt $pembayaranUkt)
    {
        $this->authorizeAction('pembayaran_ukt', 'delete', 'Anda tidak memiliki akses untuk menghapus data pembayaran UKT.');
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
