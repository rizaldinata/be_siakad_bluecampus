@extends('layouts.admin')

@section('content')
    <h2>Data Mata Kuliah</h2>
    <p class="text-muted">Daftar semua Mata Kuliah</p>

    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Tabel Mata Kuliah</h5>
            <a href="{{ route('admin.mata-kuliah.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Mata Kuliah
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode MatKul</th>
                        <th>Nama Matkul</th>
                        <th>Jenis</th>
                        <th>SKS</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mataKuliah as $index => $mk)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $mk->kode_matkul }}</td>
                            <td>{{ $mk->nama }}</td>
                            <td>{{ $mk->jenis_matkul }}</td>
                            <td>{{ $mk->sks }}</td>
                            <td>
                                {{-- Lihat Detail --}}
                                {{-- <a href="{{ route('admin.mata-kuliah.show', $mk->id) }}" class="btn btn-sm btn-info me-1">
                                    <i class="bi bi-eye-fill"></i>
                                </a> --}}

                                {{-- Edit --}}
                                <a href="{{ route('admin.mata-kuliah.edit', $mk->id) }}"
                                    class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.mata-kuliah.destroy', $mk->id) }}" method="POST"
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
                            <td colspan="6" class="text-center text-muted">Belum ada data Kelas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
