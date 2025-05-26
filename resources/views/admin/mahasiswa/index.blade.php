@extends('layouts.admin')

@section('content')
    <style>
        .btn-bluecampus {
            background-color: #003366;
            color: #fff;
            border: none;
        }

        .btn-bluecampus:hover {
            background-color: #002244;
            color: #fff;
        }

        .card-custom {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
        }

        .table thead th {
            background-color: #f8f9fa;
        }

        .badge-status {
            padding: 0.45em 0.8em;
            border-radius: 50rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-aktif {
            background-color: #198754;
            color: white;
        }

        .badge-cuti {
            background-color: #ffc107;
            color: black;
        }

        .badge-nonaktif {
            background-color: #dc3545;
            color: white;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
        }
    </style>

    <h2 class="fw-bold text-primary mb-2">Data Mahasiswa</h2>
    <p class="text-muted">Daftar semua mahasiswa yang terdaftar</p>

    <div class="card card-custom p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-semibold">Tabel Mahasiswa</h5>
            <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-bluecampus rounded-pill">
                <i class="bi bi-plus-lg me-1"></i> Tambah Mahasiswa
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NRP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Kelas</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswa as $index => $mhs)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $mhs->nrp }}</td>
                            <td>{{ $mhs->nama }}</td>
                            <td>{{ $mhs->user->email ?? '' }}</td>
                            <td>{{ $mhs->kelas->nama_kelas }}</td>
                            <td>{{ $mhs->semester }}</td>
                            <td>
                                @if ($mhs->status === 'aktif')
                                    <span class="badge-status badge-aktif">Aktif</span>
                                @elseif ($mhs->status === 'cuti')
                                    <span class="badge-status badge-cuti">Cuti</span>
                                @else
                                    <span class="badge-status badge-nonaktif">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.mahasiswa.show', $mhs->id) }}" class="btn btn-sm btn-info me-1">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                <a href="{{ route('admin.mahasiswa.edit', $mhs->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                <form action="{{ route('admin.mahasiswa.destroy', $mhs->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
