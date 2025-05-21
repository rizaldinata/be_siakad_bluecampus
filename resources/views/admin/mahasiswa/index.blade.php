@extends('layouts.admin')

@section('content')
    <h2>Data Mahasiswa</h2>
    <p class="text-muted">Daftar semua mahasiswa yang terdaftar</p>

    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Tabel Mahasiswa</h5>
            <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Mahasiswa
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Program Studi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswa as $index => $mhs)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $mhs->nim }}</td>
                            <td>{{ $mhs->nama }}</td>
                            <td>{{ $mhs->prodi }}</td>
                            <td>
                                @if ($mhs->status === 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif ($mhs->status === 'cuti')
                                    <span class="badge bg-warning text-dark">Cuti</span>
                                @else
                                    <span class="badge bg-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                {{-- Lihat Detail --}}
                                <a href="{{ route('admin.mahasiswa.show', $mhs->id) }}" class="btn btn-sm btn-info me-1">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.mahasiswa.edit', $mhs->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.mahasiswa.destroy', $mhs->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
