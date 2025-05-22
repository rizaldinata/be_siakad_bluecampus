@extends('layouts.admin')

@section('title', 'Detail Kelas')

@section('content')
    <h2>Detail Kelas</h2>
    <p class="text-muted">Informasi lengkap kelas dan daftar mahasiswa</p>

    <div class="card p-4">
        <div class="row">
            <!-- Informasi Kelas -->
            <div class="col-md-6 mb-4">
                <h5 class="text-primary mb-3">
                    <i class="bi bi-door-open me-2"></i>Informasi Kelas
                </h5>
                <div class="mb-2"><strong>Nama Kelas:</strong> {{ $kelas->nama_kelas }}</div>
                <div class="mb-2"><strong>Program Studi:</strong> {{ $kelas->program_studi }}</div>
                <div class="mb-2"><strong>Parallel Kelas:</strong> {{ $kelas->parallel_kelas }}</div>
                @php
                    $namaLengkapDosen = $dosenWali
                        ? trim(
                            ($dosenWali->gelar_depan ? $dosenWali->gelar_depan . ' ' : '') .
                                $dosenWali->nama .
                                ($dosenWali->gelar_belakang ? ', ' . $dosenWali->gelar_belakang : ''),
                        )
                        : '-';
                @endphp
                <div class="mb-2"><strong>Dosen Wali:</strong> {{ $namaLengkapDosen }}</div>
            </div>
        </div>

        <hr>

        <!-- Daftar Mahasiswa -->
        <div class="row">
            <div class="col-12">
                <h5 class="text-success mb-3">
                    <i class="bi bi-people-fill me-2"></i>Daftar Mahasiswa
                </h5>

                @if ($kelas->mahasiswas->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NRP</th>
                                    <th>Semester</th>
                                    <th>Jenis Kelamin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas->mahasiswas as $index => $mhs)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $mhs->nama }}</td>
                                        <td>{{ $mhs->nrp }}</td>
                                        <td>{{ $mhs->semester }}</td>
                                        <td>{{ ucfirst($mhs->jenis_kelamin) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Belum ada mahasiswa dalam kelas ini.</p>
                @endif
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
@endsection
