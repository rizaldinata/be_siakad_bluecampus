<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-bg: #ffffff;
            --primary-text: #2C3E50;
            --accent-color: #F1C40F;
            --hover-bg: #F4F6F9;
            --active-bg: rgba(241, 196, 15, 0.2);
            --logout-color: #E74C3C;
            --border-color: #E0E0E0;
        }

        [data-bs-theme="dark"] {
            --primary-bg: #1e1e2f;
            --primary-text: #ecf0f1;
            --hover-bg: #2c2c3c;
            --active-bg: rgba(241, 196, 15, 0.2);
            --border-color: #3e3e4e;
            --logout-color: #e74c3c;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--primary-bg);
            color: var(--primary-text);
        }

        .dashboard-wrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            background-color: var(--primary-bg);
            color: var(--primary-text);
            width: 250px;
            padding: 20px 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid var(--border-color);
        }

        .sidebar .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar .logo-container img {
            max-width: 120px;
            height: auto;
            margin-bottom: 5px;
            box-shadow: none;
            /* Hapus drop shadow */
        }

        .sidebar .description {
            font-size: 13px;
            color: #7f8c8d;
        }

        .sidebar .nav-link {
            color: var(--primary-text);
            font-size: 14px;
            font-weight: 500;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            transition: background 0.2s ease;
        }

        .sidebar .nav-link i {
            margin-right: 8px;
        }

        .sidebar .nav-link:hover {
            background-color: var(--hover-bg);
        }

        .sidebar .nav-link.active {
            background-color: var(--active-bg);
            color: var(--accent-color);
            font-weight: 600;
        }

        .content {
            margin-left: 250px;
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            background-color: #F9FAFB;
        }

        .btn-logout {
            width: 100%;
            font-size: 14px;
            background-color: var(--logout-color);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-logout:hover {
            background-color: #c0392b;
        }

        .dark-toggle {
            font-size: 13px;
            text-align: center;
            margin-top: 15px;
            color: #7f8c8d;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                flex-direction: row;
                overflow-x: auto;
                height: auto;
            }

            .content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div>
                <div class="logo-container">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo BlueCampus">
                    <div class="description">Sistem Informasi Akademik</div>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="nav-link {{ request()->is('admin/mahasiswa*') ? 'active' : '' }}"
                        href="{{ route('admin.mahasiswa.index') }}">
                        <i class="bi bi-person-lines-fill"></i> Data Mahasiswa
                    </a>
                    <a class="nav-link {{ request()->is('admin/kelas*') ? 'active' : '' }}"
                        href="{{ route('admin.kelas.index') }}">
                        <i class="bi bi-building"></i> Data Kelas
                    </a>
                    <a class="nav-link {{ request()->is('admin/dosen*') ? 'active' : '' }}"
                        href="{{ route('admin.dosen.index') }}">
                        <i class="bi bi-person-video3"></i> Data Dosen
                    </a>
                    <a class="nav-link {{ request()->is('admin/mata-kuliah*') ? 'active' : '' }}"
                        href="{{ route('admin.mata-kuliah.index') }}">
                        <i class="bi bi-journal-bookmark-fill"></i> Data Mata Kuliah
                    </a>
                    <a class="nav-link {{ request()->is('admin/paket-frs*') ? 'active' : '' }}"
                        href="{{ route('admin.paket-frs.index') }}">
                        <i class="bi bi-box-seam"></i> Data Paket FRS
                    </a>
                    <a class="nav-link {{ request()->is('admin/frs*') ? 'active' : '' }}"
                        href="{{ route('admin.frs.index') }}">
                        <i class="bi bi-file-earmark-text-fill"></i> Data FRS
                    </a>
                    <a class="nav-link {{ request()->is('admin/frs-mahasiswa*') ? 'active' : '' }}"
                        href="{{ route('admin.frs-mahasiswa.index') }}">
                        <i class="bi bi-file-person-fill"></i> Data FRS Mahasiswa
                    </a>
                    <a class="nav-link {{ request()->is('admin/jadwal*') ? 'active' : '' }}"
                        href="{{ route('admin.jadwal-kuliah.index') }}">
                        <i class="bi bi-calendar-event-fill"></i> Data Jadwal
                    </a>
                    <a class="nav-link {{ request()->is('admin/nilai*') ? 'active' : '' }}"
                        href="{{ route('admin.nilai.index') }}">
                        <i class="bi bi-bar-chart-fill"></i> Data Nilai
                    </a>
                    <a class="nav-link {{ request()->is('admin/tahun-ajaran*') ? 'active' : '' }}"
                        href="{{ route('admin.tahun-ajaran.index') }}">
                        <i class="bi bi-calendar3"></i> Data Tahun Ajaran
                    </a>
                </nav>
            </div>

            <div>
                <form method="POST" action="{{ route('web.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-logout">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>

                <div class="dark-toggle" onclick="toggleDarkMode()">
                    <i class="bi bi-moon-stars me-1"></i> Dark Mode
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load theme saat halaman dimuat
        document.addEventListener("DOMContentLoaded", function() {
            const savedTheme = localStorage.getItem("theme");
            if (savedTheme) {
                document.documentElement.setAttribute("data-bs-theme", savedTheme);
            }
        });

        function toggleDarkMode() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute("data-bs-theme");
            const newTheme = currentTheme === "dark" ? "light" : "dark";
            html.setAttribute("data-bs-theme", newTheme);
            localStorage.setItem("theme", newTheme);
        }
    </script>

    @yield('scripts')
</body>

</html>
