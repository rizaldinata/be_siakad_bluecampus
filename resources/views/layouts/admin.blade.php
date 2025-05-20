<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        html,
        body {
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f6f9fc;
            overflow: hidden;
        }

        .dashboard-wrapper {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: #ffffff;
            border-right: 1px solid #e0e0e0;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar .nav-link {
            color: #4a5568;
            font-weight: 500;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #f1f3f5;
            color: #2d3748;
        }

        .content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
        }

        .stat-card h5 {
            font-size: 14px;
            color: #718096;
            font-weight: 600;
        }

        .stat-card p {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }

        @media (max-height: 700px) {
            .content {
                padding: 20px 15px;
            }

            .sidebar {
                padding: 20px 15px;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <h4 class="mb-4">Admin Panel</h4>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-house-door-fill me-2"></i> Dashboard
                </a>

                <a class="nav-link {{ request()->is('admin/mahasiswa*') ? 'active' : '' }}"
                    href="{{ route('admin.mahasiswa.index') }}">
                    <i class="bi bi-people-fill me-2"></i> Data Mahasiswa
                </a>

                <a class="nav-link {{ request()->is('admin/dosen*') ? 'active' : '' }}" href="#">
                    <i class="bi bi-person-video2 me-2"></i> Data Dosen
                </a>

                <a class="nav-link {{ request()->is('admin/frs*') ? 'active' : '' }}" href="#">
                    <i class="bi bi-journal-text me-2"></i> Data FRS
                </a>

                <a class="nav-link {{ request()->is('admin/paket-frs*') ? 'active' : '' }}" href="#">
                    <i class="bi bi-layers me-2"></i> Data Paket FRS
                </a>

                <a class="nav-link {{ request()->is('admin/jadwal*') ? 'active' : '' }}" href="#">
                    <i class="bi bi-calendar-week me-2"></i> Data Jadwal
                </a>

                <a class="nav-link {{ request()->is('admin/nilai*') ? 'active' : '' }}" href="#">
                    <i class="bi bi-clipboard-data me-2"></i> Data Nilai
                </a>

                <form method="POST" action="{{ route('web.logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            </nav>

        </div>

        <!-- Konten -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    @yield('scripts')
</body>

</html>
