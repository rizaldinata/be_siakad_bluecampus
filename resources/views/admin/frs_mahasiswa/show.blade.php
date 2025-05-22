@extends('layouts.admin')

@section('title', 'Detail FRS Mahasiswa')

@section('content')
    <h2 class="mb-3">Detail FRS Mahasiswa</h2>
    <p class="text-muted mb-4">Informasi lengkap FRS yang diambil oleh mahasiswa</p>

    <div class="row">

        <!-- Informasi Mahasiswa -->
        <div class="col-md-6 mb-4">
            <div class="card p-4 h-100">
                <h5 class="mb-3 text-primary"><i class="bi bi-person-circle me-2"></i>Mahasiswa</h5>
                <p><strong>Nama:</strong> {{ $frsMahasiswa->mahasiswa->nama }}</p>
                <p><strong>NRP:</strong> {{ $frsMahasiswa->mahasiswa->nrp }}</p>
                <p><strong>Kelas:</strong> {{ $frsMahasiswa->mahasiswa->kelas->nama_kelas ?? '-' }}</p>
                <p><strong>Dosen Wali:</strong> {{ $frsMahasiswa->mahasiswa->dosenWali->nama ?? '-' }}</p>
            </div>
        </div>

        <!-- Informasi Mata Kuliah -->
        <div class="col-md-6 mb-4">
            <div class="card p-4 h-100">
                <h5 class="mb-3 text-success"><i class="bi bi-book-fill me-2"></i>Mata Kuliah</h5>
                <p><strong>Nama:</strong> {{ $frsMahasiswa->frs->mataKuliah->nama ?? '-' }}</p>
                <p><strong>Kode:</strong> {{ $frsMahasiswa->frs->mataKuliah->kode_matkul ?? '-' }}</p>
                <p><strong>SKS:</strong> {{ $frsMahasiswa->frs->mataKuliah->sks ?? '-' }}</p>
                <p><strong>Dosen Pengampu:</strong> {{ $frsMahasiswa->frs->dosen->nama ?? '-' }}</p>
                <p><strong>Hari:</strong> {{ ucfirst($frsMahasiswa->frs->hari) }}</p>
                <p><strong>Jam:</strong> {{ $frsMahasiswa->frs->jam_mulai }} - {{ $frsMahasiswa->frs->jam_selesai }}</p>
            </div>
        </div>

        <!-- Informasi Status & Catatan -->
        <div class="col-md-12 mb-4">
            <div class="card p-4">
                <h5 class="mb-3 text-info"><i class="bi bi-info-circle-fill me-2"></i>Status FRS</h5>
                <p><strong>Status Persetujuan:</strong>
                    @if ($frsMahasiswa->status_disetujui === 'ya')
                        <span class="badge bg-success">Disetujui</span>
                    @elseif ($frsMahasiswa->status_disetujui === 'menunggu')
                        <span class="badge bg-warning text-dark">Menunggu</span>
                    @else
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </p>
                <p><strong>Catatan:</strong> {{ $frsMahasiswa->catatan }}</p>
            </div>
        </div>

        <div class="col-12">
            <a href="{{ route('admin.frs-mahasiswa.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
@endsection
