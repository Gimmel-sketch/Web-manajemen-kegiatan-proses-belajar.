@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="auth-page">
    <div class="row justify-content-center w-100">
        <div class="col-sm-10 col-md-6 col-lg-4">
            <div class="card auth-panel shadow-sm">
                <div class="card-header bg-white">
                    <div class="auth-title">Login</div>
                    <p class="auth-subtitle">Masuk untuk mengelola data akademik kampus.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('login.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
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
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                        </div>
                        <div class="form-check mb-4">
                            <input id="remember" type="checkbox" name="remember" class="form-check-input">
                            <label for="remember" class="form-check-label">Ingat saya</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Masuk</button>
                    </form>
                </div>
                <div class="card-footer bg-white text-center py-3">
                    <span class="text-muted">Belum punya akun?</span>
                    <a class="fw-semibold text-decoration-none" href="{{ route('register') }}">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
