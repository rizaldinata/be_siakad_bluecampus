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

    <!-- Tambahan Statistik -->
    <div class="row mt-2">
        <div class="col-md-4 mb-4">
            <div class="card p-4 stat-card">
                <h5><i class="bi bi-file-earmark-text-fill me-2 text-primary"></i> Total FRS</h5>
                <p>{{ $totalFrs }}</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 stat-card">
                <h5><i class="bi bi-people-fill me-2 text-info"></i> Total Kelas</h5>
                <p>{{ $totalKelas }}</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 stat-card">
                <h5><i class="bi bi-layers-fill me-2 text-secondary"></i> Total Paket FRS</h5>
                <p>{{ $totalPaketFrs }}</p>
            </div>
        </div>
    </div>
@endsection
