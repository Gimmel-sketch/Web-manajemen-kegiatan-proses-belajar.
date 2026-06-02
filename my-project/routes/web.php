<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransaksiKrsController;
use App\Http\Controllers\TransaksiPembayaranUktController;
use App\Http\Controllers\TransaksiPeminjamanBukuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Create-mahasiswa');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

Route::get('Create-mahasiswa', [MahasiswaController::class, 'create'])
    ->name('Create-mahasiswa');

Route::post('simpan-mahasiswa', [MahasiswaController::class, 'store'])
    ->name('simpan-mahasiswa');

Route::get('Data-mahasiswa', [MahasiswaController::class, 'index'])
    ->name('Data-mahasiswa');

Route::get('edit-mahasiswa/{id}', [MahasiswaController::class, 'edit'])
    ->name('edit-mahasiswa');

Route::put('edit-mahasiswa/{id}', [MahasiswaController::class, 'update'])
    ->name('update-mahasiswa');

Route::delete('hapus-mahasiswa/{id}', [MahasiswaController::class, 'destroy'])
    ->name('hapus-mahasiswa');

Route::resource('buku', BukuController::class)->except(['show']);
Route::resource('mata-kuliah', MataKuliahController::class)->except(['show']);
Route::resource('transaksi-krs', TransaksiKrsController::class)->except(['show']);
Route::resource('pembayaran-ukt', TransaksiPembayaranUktController::class)->except(['show']);
Route::resource('peminjaman-buku', TransaksiPeminjamanBukuController::class)->except(['show']);
