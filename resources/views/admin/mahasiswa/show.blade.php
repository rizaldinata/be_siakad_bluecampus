@extends('layouts.admin')

@section('title', 'Detail Mahasiswa')

@section('content')
    <h2 class="mb-3">Detail Mahasiswa</h2>
    <p class="text-muted mb-4">Informasi lengkap mahasiswa terdaftar</p>

    <div class="row">
        <!-- Informasi Pribadi -->
        <div class="col-md-6 mb-4">
            <div class="card p-4 h-100">
                <h5 class="mb-3 text-primary"><i class="bi bi-person-circle me-2"></i>Informasi Pribadi</h5>
                <p><strong>Nama:</strong> {{ $mahasiswa->nama }}</p>
                <p><strong>Email:</strong> {{ $mahasiswa->user->email }}</p>
                <p><strong>Jenis Kelamin:</strong> {{ ucfirst($mahasiswa->jenis_kelamin) }}</p>
                <p><strong>Tanggal Lahir:</strong> {{ $mahasiswa->tanggal_lahir }}</p>
                <p><strong>Tempat Lahir:</strong> {{ $mahasiswa->tempat_lahir }}</p>
            </div>
        </div>

        <!-- Informasi Akademik -->
        <div class="col-md-6 mb-4">
            <div class="card p-4 h-100">
                <h5 class="mb-3 text-success"><i class="bi bi-mortarboard-fill me-2"></i>Informasi Akademik</h5>
                <p><strong>NIM:</strong> {{ $mahasiswa->nrp }}</p>
                <p><strong>Semester:</strong> {{ $mahasiswa->semester }}</p>
                <p><strong>Status:</strong>
                    @if ($mahasiswa->status === 'aktif')
                        <span class="badge bg-success">Aktif</span>
                    @elseif ($mahasiswa->status === 'cuti')
                        <span class="badge bg-warning text-dark">Cuti</span>
                    @else
                        <span class="badge bg-danger">Tidak Aktif</span>
                    @endif
                </p>
                <p><strong>Tanggal Masuk:</strong> {{ $mahasiswa->tanggal_masuk }}</p>
                <p><strong>Kelas:</strong> {{ $mahasiswa->kelas->nama_kelas ?? '-' }}</p>
                <p><strong>Dosen Wali:</strong> {{ $mahasiswa->dosenWali->nama ?? '-' }}</p>
            </div>
        </div>

        <!-- Kontak & Alamat -->
        <div class="col-md-12 mb-4">
            <div class="card p-4">
                <h5 class="mb-3 text-info"><i class="bi bi-telephone-fill me-2"></i>Kontak & Alamat</h5>
                <p><strong>Alamat:</strong> {{ $mahasiswa->alamat }}</p>
                <p><strong>No Telepon:</strong> {{ $mahasiswa->no_telepon }}</p>
                <p><strong>Asal Sekolah:</strong> {{ $mahasiswa->asal_sekolah }}</p>
            </div>
        </div>

        <div class="col-12">
            <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
@endsection
