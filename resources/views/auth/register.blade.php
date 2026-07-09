@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="auth-page">
    <div class="row justify-content-center w-100">
        <div class="col-sm-11 col-md-8 col-lg-5">
            <div class="card auth-panel shadow-sm">
                <div class="card-header bg-white">
                    <div class="auth-title">Register</div>
                    <p class="auth-subtitle">Buat akun baru untuk masuk ke sistem akademik.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('register.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label">Nama</label>
                                <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nama lengkap" required autofocus>
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="nama@email.com" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-4">Daftar</button>
                    </form>
                </div>
                <div class="card-footer bg-white text-center py-3">
                    <span class="text-muted">Sudah punya akun?</span>
                    <a class="fw-semibold text-decoration-none" href="{{ route('login') }}">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
