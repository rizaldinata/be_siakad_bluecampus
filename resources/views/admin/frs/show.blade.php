@extends('layouts.admin')

@section('title', 'Detail FRS')

@section('content')
    <h2>Detail FRS</h2>
    <p class="text-muted">Informasi lengkap satu entri FRS yang mencakup jadwal, mata kuliah, dosen, dan paket.</p>

    <div class="row g-4">
        <!-- Informasi Jadwal -->
        <div class="col-md-6">
            <div class="card p-3 h-100">
                <h5 class="text-primary">
                    <i class="bi bi-calendar-event me-2"></i>Informasi Jadwal
                </h5>
                <div><strong>Hari:</strong> {{ ucfirst($frs->hari) }}</div>
                <div><strong>Jam Mulai:</strong> {{ $frs->jam_mulai }}</div>
                <div><strong>Jam Selesai:</strong> {{ $frs->jam_selesai }}</div>
                <div><strong>Semester:</strong> {{ $frs->semester }}</div>
                <div><strong>Kelas:</strong> {{ $frs->kelas }}</div>
            </div>
        </div>

        <!-- Informasi Mata Kuliah -->
        <div class="col-md-6">
            <div class="card p-3 h-100">
                <h5 class="text-success">
                    <i class="bi bi-journal-bookmark me-2"></i>Informasi Mata Kuliah
                </h5>
                <div><strong>Nama Mata Kuliah:</strong> {{ $frs->mataKuliah->nama ?? '-' }}</div>
                <div><strong>Kode Matkul:</strong> {{ $frs->mataKuliah->kode_matkul ?? '-' }}</div>
                <div><strong>SKS:</strong> {{ $frs->mataKuliah->sks ?? '-' }}</div>
            </div>
        </div>

        <!-- Informasi Dosen -->
        <div class="col-md-6">
            <div class="card p-3 h-100">
                <h5 class="text-info">
                    <i class="bi bi-person-badge me-2"></i>Informasi Dosen Pengampu
                </h5>
                <div><strong>Nama:</strong> {{ $frs->dosen->nama ?? '-' }}</div>
                <div><strong>NIP:</strong> {{ $frs->dosen->nip ?? '-' }}</div>
                <div><strong>Program Studi:</strong> {{ $frs->dosen->program_studi ?? '-' }}</div>
            </div>
        </div>

        <!-- Informasi Paket FRS -->
        <div class="col-md-6">
            <div class="card p-3 h-100">
                <h5 class="text-warning">
                    <i class="bi bi-box-seam me-2"></i>Paket FRS
                </h5>
                <div><strong>Nama Paket:</strong> {{ $frs->paketFrs->nama_paket ?? '-' }}</div>
                <div><strong>Kelas:</strong> {{ $frs->paketFrs->kelas->nama_kelas ?? '-' }}</div>
            </div>
        </div>

        <!-- Jadwal Kuliah -->
        @if ($frs->jadwalKuliah)
            <div class="col-md-6">
                <div class="card p-3 h-100">
                    <h5 class="text-secondary">
                        <i class="bi bi-building me-2"></i>Jadwal Kuliah
                    </h5>
                    <div><strong>Ruangan:</strong> {{ $frs->jadwalKuliah->ruangan }}</div>
                </div>
            </div>
        @endif
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.frs.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>
@endsection
