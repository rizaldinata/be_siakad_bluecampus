@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <h2>Dashboard Admin {{ Auth::user()->name }}</h2>
    <p class="text-muted">Statistik dan aktivitas terkini</p>

    <!-- Statistik -->
    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <div class="card p-4 stat-card">
                <h5><i class="bi bi-mortarboard-fill me-2"></i> Total Mahasiswa</h5>
                <p>120</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 stat-card">
                <h5><i class="bi bi-person-badge-fill me-2"></i> Total Dosen</h5>
                <p>15</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 stat-card">
                <h5><i class="bi bi-person-fill-gear me-2"></i> Total Admin</h5>
                <p>3</p>
            </div>
        </div>
    </div>

    <!-- Mahasiswa Status -->
    <div class="row mt-2">
        <div class="col-md-4 mb-4">
            <div class="card p-4 stat-card">
                <h5><i class="bi bi-check-circle-fill me-2 text-success"></i> Mahasiswa Aktif</h5>
                <p>95</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 stat-card">
                <h5><i class="bi bi-x-circle-fill me-2 text-danger"></i> Mahasiswa Tidak Aktif</h5>
                <p>15</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 stat-card">
                <h5><i class="bi bi-pause-circle-fill me-2 text-warning"></i> Mahasiswa Cuti</h5>
                <p>10</p>
            </div>
        </div>
    </div>

    <!-- Distribusi dan Aktivitas -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card p-4">
                <h5 class="mb-3">Distribusi Status Mahasiswa</h5>
                <canvas id="statusChart" height="100"></canvas>
            </div>
        </div>
        <div class="col-md-8 mb-4">
            <div class="card p-4">
                <h5 class="mb-3">Aktivitas Terbaru</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><i class="bi bi-person-circle me-2"></i> Mahasiswa baru ditambahkan: Budi
                        Santoso</li>
                    <li class="list-group-item"><i class="bi bi-calendar-week me-2"></i> Jadwal semester genap diperbarui
                    </li>
                    <li class="list-group-item"><i class="bi bi-journal-text me-2"></i> Nilai FRS semester lalu diinput</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: ['Aktif', 'Tidak Aktif', 'Cuti'],
                datasets: [{
                    data: [95, 15, 10],
                    backgroundColor: ['#4CAF50', '#F44336', '#FF9800']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection
