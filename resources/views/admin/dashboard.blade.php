@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <h2>Dashboard Admin {{ Auth::user()->admin->nama }}</h2>
    <p class="text-muted">Statistik dan aktivitas terkini</p>

    <!-- Statistik -->
    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <div class="card p-4 stat-card">
                <h5><i class="bi bi-mortarboard-fill me-2"></i> Total Mahasiswa</h5>
                <p>{{ $totalMahasiswa }}</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 stat-card">
                <h5><i class="bi bi-person-badge-fill me-2"></i> Total Dosen</h5>
                <p>{{ $totalDosen }}</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 stat-card">
                <h5><i class="bi bi-person-fill-gear me-2"></i> Total Admin</h5>
                <p>{{ $totalAdmin }}</p>
            </div>
        </div>
    </div>

    <!-- Mahasiswa Status -->
    <div class="row mt-2">
        <div class="col-md-4 mb-4">
            <div class="card p-4 stat-card">
                <h5><i class="bi bi-check-circle-fill me-2 text-success"></i> Mahasiswa Aktif</h5>
                <p>{{ $mahasiswaAktif }}</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 stat-card">
                <h5><i class="bi bi-x-circle-fill me-2 text-danger"></i> Mahasiswa Tidak Aktif</h5>
                <p>{{ $mahasiswaNonAktif }}</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 stat-card">
                <h5><i class="bi bi-pause-circle-fill me-2 text-warning"></i> Mahasiswa Cuti</h5>
                <p>{{ $mahasiswaCuti }}</p>
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
