<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Kampus')</title>
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
            background: #111827;
        }

        .sidebar .nav-link {
            border-radius: 6px;
            color: #d1d5db;
            font-weight: 500;
            padding: .65rem .85rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #2563eb;
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
            min-height: calc(100vh - 73px);
            display: flex;
            align-items: center;
        }

        .auth-panel {
            border: 0;
            border-radius: 8px;
            overflow: hidden;
        }

        .auth-panel .card-header {
            border-bottom: 1px solid #e5e7eb;
            padding: 1.25rem 1.5rem;
        }

        .auth-panel .card-body {
            padding: 1.5rem;
        }

        .auth-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
        }

        .auth-subtitle {
            color: #6b7280;
            margin-bottom: 0;
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
                    <a class="sidebar-brand" href="{{ route('dashboard') }}">Aplikasi Kampus</a>
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
</body>
</html>
