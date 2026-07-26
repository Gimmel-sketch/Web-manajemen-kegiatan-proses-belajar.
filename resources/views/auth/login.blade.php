@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="auth-page">
    <div class="col-sm-10 col-md-6 col-lg-4">
        <div class="card auth-panel">
            <div class="card-header">
                <div class="auth-brand">
                    <span class="auth-brand-dot"></span>
                    <span class="auth-brand-dot"></span>
                    <span class="auth-brand-dot"></span>
                </div>
                <span class="auth-brand-label">Sistem Akademik</span>
                <div class="auth-title">Selamat Datang</div>
                <p class="auth-subtitle">Masuk ke akun Anda untuk melanjutkan</p>
            </div>
            <div class="card-body">
                <form action="{{ route('login.store') }}" method="POST">
                    @csrf

                    <div class="mb-3 form-group">
                        <label for="email" class="form-label">Alamat Email</label>
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </span>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            required
                            autofocus
                        >
                    </div>

                    <div class="mb-3 form-group">
                        <label for="password" class="form-label">Password</label>
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                            </svg>
                        </span>
                        <input id="password" type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check mb-0">
                            <input id="remember" type="checkbox" name="remember" class="form-check-input">
                            <label for="remember" class="form-check-label">Ingat saya</label>
                        </div>
                        <a class="small text-decoration-none fw-medium" href="#" style="color: #64748b;">Lupa password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </form>
            </div>
            <div class="card-footer text-center">
                <span class="text-muted small">Belum punya akun?</span>
                <a class="fw-semibold text-decoration-none small ms-1" href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>
</div>
@endsection
