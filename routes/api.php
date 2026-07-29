<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/mahasiswa/profile', [MahasiswaController::class, 'profile']);
    Route::get('/mahasiswa/krs', [MahasiswaController::class, 'krs']);
    Route::post('/mahasiswa/krs', [MahasiswaController::class, 'storeKrs']);
    Route::get('/mahasiswa/jadwal', [MahasiswaController::class, 'jadwal']);
    Route::get('/mahasiswa/presensi', [MahasiswaController::class, 'presensi']);
    Route::get('/mahasiswa/nilai', [MahasiswaController::class, 'nilai']);
    Route::get('/mahasiswa/ukt', [MahasiswaController::class, 'ukt']);
    Route::post('/mahasiswa/ukt', [MahasiswaController::class, 'storeUkt']);
    Route::get('/mahasiswa/peminjaman-buku', [MahasiswaController::class, 'peminjamanBuku']);
    Route::get('/mahasiswa/evaluasi', [MahasiswaController::class, 'evaluasi']);
    Route::get('/mahasiswa/mata-kuliah', [MahasiswaController::class, 'mataKuliah']);
});
