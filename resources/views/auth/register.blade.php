@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="auth-page">
    <div class="col-sm-11 col-md-8 col-lg-5">
        <div class="card auth-panel">
            <div class="card-header">
                <div class="auth-brand">
                    <span class="auth-brand-dot"></span>
                    <span class="auth-brand-dot"></span>
                    <span class="auth-brand-dot"></span>
                </div>
                <span class="auth-brand-label">Sistem Akademik</span>
                <div class="auth-title">Buat Akun Baru</div>
                <p class="auth-subtitle">Daftar untuk mengelola data akademik kampus.</p>
            </div>
            <div class="card-body">
                <form action="{{ route('register.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 form-group">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nama lengkap" required autofocus>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="nama@email.com" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6 form-group">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
                </form>
            </div>
            <div class="card-footer text-center">
                <span class="text-muted small">Sudah punya akun?</span>
                <a class="fw-semibold text-decoration-none small ms-1" href="{{ route('login') }}">Masuk</a>
            </div>
        </div>
    </div>
</div>
@endsection
