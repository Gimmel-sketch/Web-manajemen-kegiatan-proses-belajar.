<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Kampus')</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            min-height: 100vh;
        }

        .app-shell {
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
        }

        .sidebar .nav-link {
            border-radius: 8px;
            color: #94a3b8;
            font-weight: 500;
            padding: .65rem .85rem;
            transition: all .2s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(37, 99, 235, .85);
            color: #ffffff;
        }

        .sidebar-brand {
            color: #ffffff;
            font-weight: 700;
            letter-spacing: .02em;
            text-decoration: none;
        }

        .content-wrap {
            min-width: 0;
        }

        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }

        .auth-page::before {
            content: '';
            position: absolute;
            top: -40%;
            left: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(37, 99, 235, .12) 0%, transparent 70%);
            border-radius: 50%;
        }

        .auth-page::after {
            content: '';
            position: absolute;
            bottom: -30%;
            right: -15%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(99, 102, 241, .1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .auth-panel {
            border: 0;
            border-radius: 24px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 20px 60px rgba(0,0,0,.08);
            position: relative;
            z-index: 1;
        }

        .auth-panel .card-header {
            padding: 2.5rem 2.5rem 0;
            background: transparent;
            text-align: center;
            border: 0;
        }

        .auth-panel .card-body {
            padding: 1.5rem 2.5rem 1.25rem;
        }

        .auth-panel .card-footer {
            border-top: 1px solid #f1f5f9;
            padding: 1.25rem 2.5rem;
            background: transparent;
        }

        .auth-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
        }

        .auth-subtitle {
            color: #94a3b8;
            margin-bottom: 0;
            font-size: .875rem;
            margin-top: .25rem;
        }

        .auth-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            margin-bottom: .5rem;
        }

        .auth-brand-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #2563eb;
        }

        .auth-brand-dot:nth-child(2) {
            background: #6366f1;
        }

        .auth-brand-dot:nth-child(3) {
            background: #8b5cf6;
        }

        .auth-brand-label {
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #2563eb;
        }

        .auth-panel .form-group {
            position: relative;
        }

        .auth-panel .form-group .form-label {
            font-weight: 500;
            color: #475569;
            font-size: .8125rem;
            margin-bottom: .4rem;
        }

        .auth-panel .form-control {
            border-radius: 12px;
            padding: .75rem 1rem .75rem 2.75rem;
            border: 1.5px solid #e2e8f0;
            transition: all .2s ease;
            font-size: .875rem;
            background: #f8fafc;
            height: 48px;
        }

        .auth-panel .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .1);
            background: #ffffff;
        }

        .auth-panel .form-control::placeholder {
            color: #cbd5e1;
        }

        .auth-panel .input-icon {
            position: absolute;
            left: 1rem;
            top: 42px;
            width: 20px;
            height: 20px;
            color: #94a3b8;
            pointer-events: none;
        }

        .auth-panel .input-icon svg {
            width: 100%;
            height: 100%;
            fill: currentColor;
        }

        .auth-panel .btn-primary {
            border-radius: 12px;
            padding: .75rem 1rem;
            font-weight: 600;
            font-size: .875rem;
            background: #2563eb;
            border: 0;
            transition: all .2s ease;
            height: 48px;
        }

        .auth-panel .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37, 99, 235, .35);
        }

        .auth-panel .form-check-input {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 1.5px solid #cbd5e1;
            margin-top: 0;
        }

        .auth-panel .form-check-input:checked {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        .auth-panel .form-check-label {
            color: #64748b;
            font-size: .875rem;
        }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.25rem 0;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #f1f5f9;
        }

        .auth-divider span {
            color: #94a3b8;
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .welcome-card {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
            border-radius: 16px;
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(37, 99, 235, .2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .welcome-card::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(99, 102, 241, .15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .welcome-card .card-body {
            position: relative;
            z-index: 1;
        }

        .stat-card {
            border: 0;
            border-radius: 14px;
            transition: all .25s ease;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, .1) !important;
        }

        .stat-card .card-body {
            padding: 1.25rem 1.5rem;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: .5rem;
        }

        .profile-card {
            border: 0;
            border-radius: 14px;
        }

        .text-white-90 {
            color: rgba(255, 255, 255, .75);
        }

        .tracking-wide {
            letter-spacing: .05em;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
        }

        .page-header {
            padding: 0 0 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        .content-card {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
            overflow: hidden;
        }

        .content-card .card-header {
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: #0f172a;
        }

        .content-card .card-body {
            padding: 1.5rem;
        }

        .table-modern {
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-modern thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            font-size: .8125rem;
            padding: .75rem 1rem;
            border-bottom: 1.5px solid #e2e8f0;
            white-space: nowrap;
        }

        .table-modern tbody td {
            padding: .75rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: .9375rem;
        }

        .table-modern tbody tr:last-child td {
            border-bottom: 0;
        }

        .table-modern tbody tr:hover {
            background: #f8fafc;
        }

        .btn-action {
            border-radius: 8px;
            padding: .35rem .75rem;
            font-size: .8rem;
            font-weight: 500;
            transition: all .15s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-action:hover {
            transform: translateY(-1px);
        }

        .btn-edit {
            background: #fffbeb;
            color: #d97706;
            border: 1px solid #fde68a;
        }
        .btn-edit:hover { background: #fef3c7; color: #b45309; }

        .btn-delete {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        .btn-delete:hover { background: #fee2e2; color: #b91c1c; }

        .btn-view {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
        }
        .btn-view:hover { background: #dbeafe; color: #1d4ed8; }

        .btn-verify {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }
        .btn-verify:hover { background: #dcfce7; color: #15803d; }

        .btn-fuzzy {
            background: #f5f3ff;
            color: #7c3aed;
            border: 1px solid #ddd6fe;
        }
        .btn-fuzzy:hover { background: #ede9fe; color: #6d28d9; }

        .btn-add {
            background: #2563eb;
            color: #ffffff;
            border: 0;
            border-radius: 10px;
            padding: .5rem 1.25rem;
            font-weight: 600;
            font-size: .85rem;
            transition: all .15s ease;
            text-decoration: none;
        }
        .btn-add:hover { background: #1d4ed8; color: #fff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,.35); }

        .btn-back {
            background: #ffffff;
            color: #475569;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: .5rem 1rem;
            font-weight: 500;
            font-size: .85rem;
            transition: all .15s ease;
            text-decoration: none;
        }
        .btn-back:hover { background: #f8fafc; border-color: #cbd5e1; color: #0f172a; }

        .btn-submit {
            border-radius: 10px;
            padding: .55rem 1.5rem;
            font-weight: 600;
            font-size: .875rem;
            background: #2563eb;
            color: #fff;
            border: 0;
            transition: all .15s ease;
        }
        .btn-submit:hover { background: #1d4ed8; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,.35); }

        .btn-cancel {
            border-radius: 10px;
            padding: .55rem 1.5rem;
            font-weight: 500;
            font-size: .875rem;
            background: #ffffff;
            color: #475569;
            border: 1.5px solid #e2e8f0;
            transition: all .15s ease;
            text-decoration: none;
        }
        .btn-cancel:hover { background: #f8fafc; border-color: #cbd5e1; color: #0f172a; }

        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
            color: #94a3b8;
        }

        .fuzzy-alert {
            border-radius: 12px;
            border: 0;
            padding: 1rem 1.25rem;
        }

        .form-section .form-label {
            font-weight: 500;
            color: #475569;
            font-size: .8rem;
            margin-bottom: .35rem;
        }

        .form-section .form-control,
        .form-section .form-select {
            border-radius: 10px;
            padding: .55rem .85rem;
            border: 1.5px solid #e2e8f0;
            font-size: .875rem;
            background: #f8fafc;
            transition: all .15s ease;
        }

        .form-section .form-control:focus,
        .form-section .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
            background: #ffffff;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                width: 100%;
                min-height: auto;
            }
        }
    </style>
</head>
<body class="bg-light">
    @php
        $menuItems = [
            ['label' => 'Dashboard', 'route' => 'dashboard', 'patterns' => ['dashboard'], 'permission' => null, 'group' => 'General'],

            ['label' => 'Data Mahasiswa', 'route' => 'Data-mahasiswa', 'patterns' => ['Data-mahasiswa', 'Create-mahasiswa', 'edit-mahasiswa'], 'permission' => 'mahasiswa.view', 'group' => 'Akademik'],
            ['label' => 'Dosen', 'route' => 'dosen.index', 'patterns' => ['dosen.*'], 'permission' => 'dosen.view', 'group' => 'Akademik'],
            ['label' => 'Mata Kuliah', 'route' => 'mata-kuliah.index', 'patterns' => ['mata-kuliah.*'], 'permission' => 'mata_kuliah.view', 'group' => 'Akademik'],
            ['label' => 'Ruangan', 'route' => 'ruangan.index', 'patterns' => ['ruangan.*'], 'permission' => 'ruangan.view', 'group' => 'Akademik'],
            ['label' => 'Buku', 'route' => 'buku.index', 'patterns' => ['buku.*'], 'permission' => 'buku.view', 'group' => 'Akademik'],
            ['label' => 'Peminjaman', 'route' => 'peminjaman-buku.index', 'patterns' => ['peminjaman-buku.*'], 'permission' => 'peminjaman_buku.view', 'group' => 'Akademik'],

            ['label' => 'KRS', 'route' => 'transaksi-krs.index', 'patterns' => ['transaksi-krs.*'], 'permission' => 'krs.view', 'group' => 'Aktivitas Akademik'],
            ['label' => 'Jadwal', 'route' => 'jadwal-perkuliahan.index', 'patterns' => ['jadwal-perkuliahan.*'], 'permission' => 'jadwal_perkuliahan.view', 'group' => 'Aktivitas Akademik'],
            ['label' => 'Presensi', 'route' => 'presensi-perkuliahan.index', 'patterns' => ['presensi-perkuliahan.*'], 'permission' => 'presensi_perkuliahan.view', 'group' => 'Aktivitas Akademik'],
            ['label' => 'Nilai', 'route' => 'nilai-perkuliahan.index', 'patterns' => ['nilai-perkuliahan.*'], 'permission' => 'nilai_perkuliahan.view', 'group' => 'Aktivitas Akademik'],

            ['label' => 'UKT', 'route' => 'pembayaran-ukt.index', 'patterns' => ['pembayaran-ukt.*'], 'permission' => 'pembayaran_ukt.view', 'group' => 'Transaksi'],
        ];

        $sidebarGroups = [
            'General' => [
                'items' => array_filter($menuItems, fn ($item) => $item['group'] === 'General'),
            ],
            'Akademik' => [
                'items' => array_filter($menuItems, fn ($item) => $item['group'] === 'Akademik'),
            ],
            'Aktivitas Akademik' => [
                'items' => array_filter($menuItems, fn ($item) => $item['group'] === 'Aktivitas Akademik'),
            ],
            'Transaksi' => [
                'items' => array_filter($menuItems, fn ($item) => $item['group'] === 'Transaksi'),
            ],
        ];

        $groupOrder = array_keys($sidebarGroups);
    @endphp

    <div class="app-shell @auth d-lg-flex @endauth">
        @auth
            <aside class="sidebar text-white flex-shrink-0">
                <div class="d-flex align-items-center justify-content-between p-3 border-bottom border-secondary">
                    <a class="sidebar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                        <img src="{{ asset('logo.png') }}" alt="Logo" height="32">
                        Aplikasi Kampus
                    </a>
                    <button class="btn btn-outline-light btn-sm d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false">
                        Menu
                    </button>
                </div>

                <div class="collapse d-lg-block" id="sidebarMenu">
                    <nav class="nav flex-column gap-1 p-3">
                        @foreach($groupOrder as $idx => $groupName)
                            <div class="small text-secondary mt-1 mb-1">{{ $groupName }}</div>

                            @foreach($sidebarGroups[$groupName]['items'] as $menuItem)
                                @if($menuItem['permission'] === null || auth()->user()->hasPermission($menuItem['permission']))
                                    <a class="nav-link {{ request()->routeIs(...$menuItem['patterns']) ? 'active' : '' }}" href="{{ route($menuItem['route']) }}">
                                        {{ $menuItem['label'] }}
                                    </a>
                                @endif
                            @endforeach

                            @if($idx < count($groupOrder) - 1)
                                <div class="border-top border-secondary my-2"></div>
                            @endif
                        @endforeach

                        {{-- Sistem --}}
                        @if(auth()->user()->hasRole(['admin', 'editor']) && auth()->user()->hasPermission('roles.view'))
                            <div class="border-top border-secondary my-2"></div>
                            <div class="small text-secondary mt-1 mb-1">System</div>
                            <a class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                                Roles
                            </a>
                        @endif
                    </nav>

                    <div class="p-3 border-top border-secondary">
                        <div class="small text-secondary mb-1">Login sebagai</div>
                        <div class="fw-semibold">{{ auth()->user()->name }}</div>
                        @if(auth()->user()->role)
                            <span class="badge text-bg-secondary mt-2">{{ auth()->user()->role->display_name }}</span>
                        @endif

                        <form class="mt-3" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-outline-light btn-sm w-100" type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </aside>
        @else
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100">
                <div class="container">
                    <a class="navbar-brand" href="/">Aplikasi Kampus</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#guestNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="guestNavbar">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        @endauth

        <div class="content-wrap flex-grow-1">
            @auth
                <header class="bg-white border-bottom px-4 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Halaman</div>
                            <div class="fw-semibold">@yield('title', 'Aplikasi Kampus')</div>
                        </div>
                    </div>
                </header>
            @endauth

            <main class="container-fluid px-4 py-4">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <strong>Data belum bisa disimpan.</strong>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
