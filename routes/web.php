<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\TransaksiKrsController;
use App\Http\Controllers\TransaksiJadwalPerkuliahanController;
use App\Http\Controllers\TransaksiNilaiPerkuliahanController;
use App\Http\Controllers\TransaksiPembayaranUktController;
use App\Http\Controllers\TransaksiPeminjamanBukuController;
use App\Http\Controllers\TransaksiPresensiPerkuliahanController;
use App\Models\Buku;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Role;
use App\Models\Ruangan;
use App\Models\TransaksiKrs;
use App\Models\TransaksiJadwalPerkuliahan;
use App\Models\TransaksiNilaiPerkuliahan;
use App\Models\TransaksiPembayaranUkt;
use App\Models\TransaksiPeminjamanBuku;
use App\Models\TransaksiPresensiPerkuliahan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect('/dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'totalMahasiswa' => Mahasiswa::count(),
            'totalMataKuliah' => MataKuliah::count(),
            'totalDosen' => Dosen::count(),
            'totalRuangan' => Ruangan::count(),
            'totalBuku' => Buku::count(),
            'totalKrs' => TransaksiKrs::count(),
            'totalJadwalPerkuliahan' => TransaksiJadwalPerkuliahan::count(),
            'totalPresensiPerkuliahan' => TransaksiPresensiPerkuliahan::count(),
            'totalNilaiPerkuliahan' => TransaksiNilaiPerkuliahan::count(),
            'totalPembayaranUkt' => TransaksiPembayaranUkt::count(),
            'totalPeminjamanBuku' => TransaksiPeminjamanBuku::count(),
            'totalRoles' => Role::count(),
        ]);
    })->name('dashboard');

    Route::middleware('role:admin,editor')->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->middleware('permission:roles.view')->name('roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->middleware('permission:roles.create')->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->middleware('permission:roles.create')->name('roles.store');
        Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->middleware('permission:roles.update')->name('roles.edit');
        Route::put('/roles/{id}', [RoleController::class, 'update'])->middleware('permission:roles.update')->name('roles.update');
        Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->middleware('permission:roles.delete')->name('roles.destroy');
    });

    Route::middleware('permission:mahasiswa.create')->group(function () {
        Route::get('Create-mahasiswa', [MahasiswaController::class, 'create'])
            ->name('Create-mahasiswa');

        Route::post('simpan-mahasiswa', [MahasiswaController::class, 'store'])
            ->name('simpan-mahasiswa');
    });

    Route::middleware('permission:mahasiswa.view')->group(function () {
        Route::get('Data-mahasiswa', [MahasiswaController::class, 'index'])
            ->name('Data-mahasiswa');
        Route::get('mahasiswa/{nim}/evaluasi', [MahasiswaController::class, 'evaluasi'])
            ->name('mahasiswa.evaluasi');
    });

    Route::middleware('permission:mahasiswa.update')->group(function () {
        Route::get('edit-mahasiswa/{id}', [MahasiswaController::class, 'edit'])
            ->name('edit-mahasiswa');

        Route::put('edit-mahasiswa/{id}', [MahasiswaController::class, 'update'])
            ->name('update-mahasiswa');
    });

    Route::middleware('permission:mahasiswa.delete')->group(function () {
        Route::delete('hapus-mahasiswa/{id}', [MahasiswaController::class, 'destroy'])
            ->name('hapus-mahasiswa');
    });

    Route::resource('buku', BukuController::class)->except(['show'])
        ->middlewareFor('index', 'permission:buku.view')
        ->middlewareFor(['create', 'store'], 'permission:buku.create')
        ->middlewareFor(['edit', 'update'], 'permission:buku.update')
        ->middlewareFor('destroy', 'permission:buku.delete');
    Route::resource('dosen', DosenController::class)->except(['show'])
        ->middlewareFor('index', 'permission:dosen.view')
        ->middlewareFor(['create', 'store'], 'permission:dosen.create')
        ->middlewareFor(['edit', 'update'], 'permission:dosen.update')
        ->middlewareFor('destroy', 'permission:dosen.delete');
    Route::resource('ruangan', RuanganController::class)->except(['show'])
        ->middlewareFor('index', 'permission:ruangan.view')
        ->middlewareFor(['create', 'store'], 'permission:ruangan.create')
        ->middlewareFor(['edit', 'update'], 'permission:ruangan.update')
        ->middlewareFor('destroy', 'permission:ruangan.delete');
    Route::resource('mata-kuliah', MataKuliahController::class)->except(['show'])
        ->middlewareFor('index', 'permission:mata_kuliah.view')
        ->middlewareFor(['create', 'store'], 'permission:mata_kuliah.create')
        ->middlewareFor(['edit', 'update'], 'permission:mata_kuliah.update')
        ->middlewareFor('destroy', 'permission:mata_kuliah.delete');
    Route::resource('transaksi-krs', TransaksiKrsController::class)->except(['show'])
        ->middlewareFor('index', 'permission:krs.view')
        ->middlewareFor(['create', 'store'], 'permission:krs.create')
        ->middlewareFor(['edit', 'update'], 'permission:krs.update')
        ->middlewareFor('destroy', 'permission:krs.delete');
    Route::get('transaksi-krs/mahasiswa/{nim}', [TransaksiKrsController::class, 'byMahasiswa'])
        ->middleware('permission:krs.view')
        ->name('transaksi-krs.by-mahasiswa');
    Route::put('transaksi-krs/{transaksiKr}/verify', [TransaksiKrsController::class, 'verify'])
        ->middleware(['role:admin', 'permission:krs.update'])
        ->name('transaksi-krs.verify');
    Route::put('transaksi-krs/{transaksiKr}/unverify', [TransaksiKrsController::class, 'unverify'])
        ->middleware(['role:admin', 'permission:krs.update'])
        ->name('transaksi-krs.unverify');
    Route::resource('jadwal-perkuliahan', TransaksiJadwalPerkuliahanController::class)
        ->parameters(['jadwal-perkuliahan' => 'jadwalPerkuliahan'])
        ->except(['show'])
        ->middlewareFor('index', 'permission:jadwal_perkuliahan.view')
        ->middlewareFor(['create', 'store'], 'permission:jadwal_perkuliahan.create')
        ->middlewareFor(['edit', 'update'], 'permission:jadwal_perkuliahan.update')
        ->middlewareFor('destroy', 'permission:jadwal_perkuliahan.delete');
    Route::resource('presensi-perkuliahan', TransaksiPresensiPerkuliahanController::class)
        ->parameters(['presensi-perkuliahan' => 'presensiPerkuliahan'])
        ->except(['show'])
        ->middlewareFor('index', 'permission:presensi_perkuliahan.view')
        ->middlewareFor(['create', 'store'], 'permission:presensi_perkuliahan.create')
        ->middlewareFor(['edit', 'update'], 'permission:presensi_perkuliahan.update')
        ->middlewareFor('destroy', 'permission:presensi_perkuliahan.delete');
    Route::resource('nilai-perkuliahan', TransaksiNilaiPerkuliahanController::class)
        ->parameters(['nilai-perkuliahan' => 'nilaiPerkuliahan'])
        ->except(['show'])
        ->middlewareFor('index', 'permission:nilai_perkuliahan.view')
        ->middlewareFor(['create', 'store'], 'permission:nilai_perkuliahan.create')
        ->middlewareFor(['edit', 'update'], 'permission:nilai_perkuliahan.update')
        ->middlewareFor('destroy', 'permission:nilai_perkuliahan.delete');
    Route::get('nilai-perkuliahan/{nilaiPerkuliahan}/fuzzy-detail', [TransaksiNilaiPerkuliahanController::class, 'fuzzyDetail'])
        ->middleware('permission:nilai_perkuliahan.view')
        ->name('nilai-perkuliahan.fuzzy-detail');
    Route::resource('pembayaran-ukt', TransaksiPembayaranUktController::class)->except(['show'])
        ->middlewareFor('index', 'permission:pembayaran_ukt.view')
        ->middlewareFor(['create', 'store'], 'permission:pembayaran_ukt.create')
        ->middlewareFor(['edit', 'update'], 'permission:pembayaran_ukt.update')
        ->middlewareFor('destroy', 'permission:pembayaran_ukt.delete');
    Route::resource('peminjaman-buku', TransaksiPeminjamanBukuController::class)->except(['show'])
        ->middlewareFor('index', 'permission:peminjaman_buku.view')
        ->middlewareFor(['create', 'store'], 'permission:peminjaman_buku.create')
        ->middlewareFor(['edit', 'update'], 'permission:peminjaman_buku.update')
        ->middlewareFor('destroy', 'permission:peminjaman_buku.delete');
});
