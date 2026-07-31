<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Akademik - Kelola Akademik Kampus Lebih Mudah</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --dark: #0f172a;
            --dark-soft: #1e293b;
            --ink: #334155;
        }

        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: var(--ink);
            background: #ffffff;
            overflow-x: hidden;
        }

        .navbar-landing {
            background: rgba(15, 23, 42, .92);
            backdrop-filter: blur(10px);
            transition: background .2s ease;
        }

        .navbar-landing .navbar-brand {
            color: #ffffff;
            font-weight: 700;
            letter-spacing: .02em;
        }

        .navbar-landing .nav-link {
            color: rgba(255, 255, 255, .8);
            font-weight: 500;
            padding: .5rem .85rem;
            border-radius: 8px;
            transition: all .15s ease;
        }

        .navbar-landing .nav-link:hover {
            color: #ffffff;
            background: rgba(37, 99, 235, .35);
        }

        .btn-primary-landing {
            background: var(--primary);
            color: #ffffff;
            border: 0;
            border-radius: 12px;
            padding: .75rem 1.5rem;
            font-weight: 600;
            font-size: .9rem;
            transition: all .2s ease;
        }

        .btn-primary-landing:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, .4);
            color: #ffffff;
        }

        .btn-outline-landing {
            background: transparent;
            color: #ffffff;
            border: 1.5px solid rgba(255, 255, 255, .35);
            border-radius: 12px;
            padding: .75rem 1.5rem;
            font-weight: 600;
            font-size: .9rem;
            transition: all .2s ease;
        }

        .btn-outline-landing:hover {
            background: rgba(255, 255, 255, .1);
            border-color: #ffffff;
            color: #ffffff;
        }

        .hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #1e3a5f 100%);
            color: #ffffff;
            position: relative;
            overflow: hidden;
            padding: 7rem 0 6rem;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -15%;
            width: 640px;
            height: 640px;
            background: radial-gradient(circle, rgba(37, 99, 235, .28) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -35%;
            left: -10%;
            width: 520px;
            height: 520px;
            background: radial-gradient(circle, rgba(99, 102, 241, .18) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero .container {
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(37, 99, 235, .18);
            border: 1px solid rgba(37, 99, 235, .4);
            color: #bfdbfe;
            padding: .4rem .9rem;
            border-radius: 999px;
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .03em;
        }

        .hero-title {
            font-size: 2.75rem;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -.02em;
        }

        .hero-subtitle {
            color: rgba(255, 255, 255, .72);
            font-size: 1.1rem;
            line-height: 1.7;
        }

        .hero-card {
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(8px);
        }

        .hero-card .list-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            color: rgba(255, 255, 255, .85);
            padding: .55rem 0;
            font-size: .95rem;
        }

        .hero-card .list-item svg {
            flex-shrink: 0;
            width: 20px;
            height: 20px;
            fill: #60a5fa;
        }

        .hero-card .auth-brand-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #2563eb;
        }

        .hero-card .auth-brand-dot:nth-child(2) { background: #6366f1; }
        .hero-card .auth-brand-dot:nth-child(3) { background: #8b5cf6; }

        .section-title {
            font-size: 1.9rem;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -.01em;
        }

        .section-subtitle {
            color: #64748b;
            font-size: 1rem;
        }

        .feature-card {
            border: 0;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .04), 0 12px 32px rgba(0, 0, 0, .06);
            padding: 1.75rem 1.5rem;
            height: 100%;
            transition: all .25s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1px 3px rgba(0, 0, 0, .04), 0 20px 48px rgba(15, 23, 42, .12);
        }

        .feature-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .feature-icon svg {
            width: 26px;
            height: 26px;
            fill: currentColor;
        }

        .feature-card h5 {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: .5rem;
        }

        .feature-card p {
            color: #64748b;
            font-size: .9rem;
            margin: 0;
            line-height: 1.65;
        }

        .stats-section {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            padding: 4rem 0;
        }

        .stat-number {
            font-size: 2.4rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -.02em;
        }

        .stat-label {
            color: rgba(255, 255, 255, .65);
            font-size: .9rem;
            margin-top: .25rem;
        }

        .cta-section {
            background: #f8fafc;
            padding: 4.5rem 0;
        }

        .cta-card {
            background: linear-gradient(135deg, #2563eb 0%, #6366f1 100%);
            border-radius: 24px;
            padding: 3rem 2rem;
            color: #ffffff;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-card::before {
            content: '';
            position: absolute;
            top: -60%;
            left: -15%;
            width: 420px;
            height: 420px;
            background: radial-gradient(circle, rgba(255, 255, 255, .14) 0%, transparent 70%);
            border-radius: 50%;
        }

        .cta-card .container {
            position: relative;
            z-index: 1;
        }

        .cta-title {
            font-size: 1.9rem;
            font-weight: 800;
        }

        .footer {
            background: #0f172a;
            color: rgba(255, 255, 255, .7);
            padding: 2.5rem 0;
        }

        .footer .brand {
            color: #ffffff;
            font-weight: 700;
        }

        .footer a {
            color: rgba(255, 255, 255, .7);
            text-decoration: none;
            transition: color .15s ease;
        }

        .footer a:hover {
            color: #ffffff;
        }

        @media (max-width: 767.98px) {
            .hero {
                padding: 4.5rem 0 4rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-landing sticky-top py-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="/">
                <img src="{{ asset('logo.png') }}" alt="Logo" height="34">
                Sistem Akademik
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#landingNavbar" aria-controls="landingNavbar" aria-expanded="false" aria-label="Buka menu navigasi">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="landingNavbar">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1 mt-3 mt-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                    <li class="nav-item ms-lg-3 d-flex gap-2 mt-2 mt-lg-0">
                        <a class="btn btn-outline-landing btn-sm flex-grow-1" href="{{ route('login') }}">Masuk</a>
                        <a class="btn btn-primary-landing btn-sm flex-grow-1" href="{{ route('register') }}">Daftar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="hero-badge mb-3">
                        <span class="auth-brand-dot"></span>
                        <span class="auth-brand-dot"></span>
                        <span class="auth-brand-dot"></span>
                        Sistem Informasi Akademik
                    </span>
                    <h1 class="hero-title mb-3">Kelola Seluruh Aktivitas Akademik Kampus dalam Satu Platform</h1>
                    <p class="hero-subtitle mb-4">Kelola data mahasiswa, dosen, mata kuliah, KRS, jadwal, presensi, nilai dengan evaluasi fuzzy, pembayaran UKT, hingga peminjaman buku — cepat, rapi, dan aman.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a class="btn btn-primary-landing" href="{{ route('login') }}">Masuk Sekarang</a>
                        <a class="btn btn-outline-landing" href="{{ route('register') }}">Buat Akun Baru</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-card">
                        <ul class="list-unstyled mb-0">
                            <li class="list-item">
                                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                KRS dan jadwal perkuliahan terpusat
                            </li>
                            <li class="list-item">
                                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                Presensi dan penilaian otomatis
                            </li>
                            <li class="list-item">
                                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                Evaluasi nilai dengan logika fuzzy
                            </li>
                            <li class="list-item">
                                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                Manajemen UKT dan peminjaman buku
                            </li>
                            <li class="list-item">
                                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                Kontrol hak akses per peran pengguna
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-5">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="section-title mb-2">Fitur Lengkap untuk Akademik</h2>
                <p class="section-subtitle mb-0">Semua kebutuhan pengelolaan akademik dalam satu aplikasi yang mudah digunakan.</p>
            </div>
            <div class="row g-4">
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon bg-primary bg-opacity-10 text-primary">
                            <svg viewBox="0 0 24 24"><path d="M19 5v14H5V5h14m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                        </div>
                        <h5>KRS &amp; Jadwal</h5>
                        <p>Penyusunan Kartu Rencana Studi dan jadwal perkuliahan yang terorganisir serta dapat diverifikasi.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon bg-success bg-opacity-10 text-success">
                            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        </div>
                        <h5>Presensi Perkuliahan</h5>
                        <p>Pencatatan kehadiran perkuliahan per mahasiswa secara cepat dan terpusat untuk setiap pertemuan.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon bg-warning bg-opacity-10 text-warning">
                            <svg viewBox="0 0 24 24"><path d="M12 14.5l2.5 2.5-2.5 2.5L9.5 17 12 14.5zM11 2h2v5h-2V2zM4 13h5v2H4v-2zm11 0h5v2h-5v-2zM5.6 4.2l1.4-1.4L11 6.8 9.6 8.2 5.6 4.2zm11.4 0l-4 4L16.9 8.2l4-4-1.4-1.4z"/></svg>
                        </div>
                        <h5>Nilai &amp; Evaluasi Fuzzy</h5>
                        <p>Pengelolaan nilai perkuliahan lengkap dengan evaluasi berbasis logika fuzzy untuk prediksi kelulusan.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon bg-danger bg-opacity-10 text-danger">
                            <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        </div>
                        <h5>Pembayaran UKT</h5>
                        <p>Pencatatan transaksi pembayaran Uang Kuliah Tunggal mahasiswa yang mudah dilacak dan dilaporkan.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon bg-info bg-opacity-10 text-info">
                            <svg viewBox="0 0 24 24"><path d="M4 6h16v12H4zM2 4v16h20V4H2zm14 5h4v2h-4V9zm0 4h4v2h-4v-2zm-6 4h10v2H10v-2zM6 7h4v10H6V7z"/></svg>
                        </div>
                        <h5>Peminjaman Buku</h5>
                        <p>Manajemen perpustakaan: data buku dan transaksi peminjaman untuk seluruh mahasiswa.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon bg-secondary bg-opacity-10 text-secondary">
                            <svg viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
                        </div>
                        <h5>Hak Akses Aman</h5>
                        <p>Pengaturan role dan permission per pengguna, memastikan setiap data hanya diakses pihak yang berwenang.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang" class="stats-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title text-white mb-2">Platform Terpercaya</h2>
                <p class="section-subtitle text-white-50 mb-0">Mendukung operasional akademik kampus secara menyeluruh.</p>
            </div>
            <div class="row g-4 text-center">
                <div class="col-6 col-lg-3">
                    <div class="stat-number">10+</div>
                    <div class="stat-label">Modul Akademik</div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-number">3</div>
                    <div class="stat-label">Peran Pengguna</div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-number">1</div>
                    <div class="stat-label">Platform Terpusat</div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Akses Sistem</div>
                </div>
            </div>
        </div>
    </section>

    <section id="kontak" class="cta-section">
        <div class="container">
            <div class="cta-card">
                <div class="container">
                    <h2 class="cta-title mb-3">Siap Memulai?</h2>
                    <p class="mb-4 text-white-50" style="color: rgba(255,255,255,.75) !important;">Masuk ke akun Anda untuk mulai mengelola data akademik kampus.</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center">
                        <a class="btn btn-primary-landing" style="background: #ffffff; color: #2563eb;" href="{{ route('login') }}">Masuk ke Akun</a>
                        <a class="btn btn-outline-landing" href="{{ route('register') }}">Daftar Akun</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <img src="{{ asset('logo.png') }}" alt="Logo" height="28">
                        <span class="brand">Sistem Akademik</span>
                    </div>
                    <p class="small mb-0">Kelola data akademik kampus secara cepat, rapi, dan aman dalam satu platform terpadu.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="small mb-0">&copy; 2026 Sistem Akademik. Seluruh hak cipta dilindungi.</p>
                    <div class="mt-1">
                        <a class="small me-3" href="{{ route('login') }}">Masuk</a>
                        <a class="small" href="{{ route('register') }}">Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
