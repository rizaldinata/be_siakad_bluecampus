@extends('layouts.admin')

@section('title', 'Detail Dosen')

@section('content')
    <h2 class="mb-3">Detail Dosen</h2>
    <p class="text-muted mb-4">Informasi lengkap dosen terdaftar</p>

    <div class="row">

        <!-- Informasi Pribadi -->
        <div class="col-md-6 mb-4">
            <div class="card p-4 h-100">
                <h5 class="mb-3 text-primary"><i class="bi bi-person-circle me-2"></i>Informasi Pribadi</h5>
                <p><strong>Nama:</strong> {{ $dosen->nama }}</p>
                <p><strong>Email:</strong> {{ $dosen->user->email }}</p>
                <p><strong>NIP:</strong> {{ $dosen->nip }}</p>
                <p><strong>Gelar Depan:</strong> {{ $dosen->gelar_depan }}</p>
                <p><strong>Gelar Belakang:</strong> {{ $dosen->gelar_belakang }}</p>
                <p><strong>Jenis Kelamin:</strong> {{ ucfirst($dosen->jenis_kelamin) }}</p>
            </div>
        </div>

        <!-- Informasi Akademik -->
        <div class="col-md-6 mb-4">
            <div class="card p-4 h-100">
                <h5 class="mb-3 text-success"><i class="bi bi-mortarboard-fill me-2"></i>Informasi Akademik</h5>
                <p><strong>Program Studi:</strong> {{ $dosen->program_studi }}</p>
            </div>
        </div>

        <!-- Kontak & Alamat -->
        <div class="col-md-12 mb-4">
            <div class="card p-4">
                <h5 class="mb-3 text-info"><i class="bi bi-telephone-fill me-2"></i>Kontak & Alamat</h5>
                <p><strong>No Telepon:</strong> {{ $dosen->no_telp }}</p>
                <p><strong>Alamat:</strong> {{ $dosen->alamat }}</p>
            </div>
        </div>

        <div class="col-12">
            <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
@endsection
