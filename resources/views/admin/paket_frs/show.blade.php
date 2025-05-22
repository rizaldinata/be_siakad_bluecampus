@extends('layouts.admin')

@section('title', 'Detail Paket FRS')

@section('content')
    <h2>Detail Paket FRS</h2>
    <p class="text-muted">Informasi lengkap paket FRS dan daftar FRS di dalamnya</p>

    <div class="card p-4">
        <div class="row">
            <!-- Informasi Paket FRS -->
            <div class="col-md-6 mb-4">
                <h5 class="text-primary mb-3">
                    <i class="bi bi-box-seam me-2"></i>Informasi Paket
                </h5>
                <div class="mb-2"><strong>Nama Paket:</strong> {{ $paketFrs->nama_paket }}</div>
                <div class="mb-2"><strong>Kelas:</strong> {{ $paketFrs->kelas->nama_kelas ?? '-' }}</div>
            </div>
        </div>

        <hr>

        <!-- Daftar FRS dalam Paket -->
        <div class="row">
            <div class="col-12">
                <h5 class="text-success mb-3">
                    <i class="bi bi-journal-text me-2"></i>Daftar FRS dalam Paket
                </h5>

                @if ($paketFrs->frs->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Mata Kuliah</th>
                                    <th>SKS</th>
                                    <th>Semester</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paketFrs->frs as $index => $frs)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $frs->mataKuliah->kode_matkul ?? '-' }}</td>
                                        <td>{{ $frs->mataKuliah->nama ?? '-' }}</td>
                                        <td>{{ $frs->mataKuliah->sks ?? '-' }}</td>
                                        <td>{{ $frs->semester }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Belum ada FRS yang ditambahkan ke paket ini.</p>
                @endif
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.paket-frs.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
@endsection
