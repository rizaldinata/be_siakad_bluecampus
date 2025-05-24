@extends('layouts.admin')

@section('content')
    <h2>Data Tahun Ajaran</h2>
    <p class="text-muted">Daftar semua tahun ajaran dan statistik FRS</p>

    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Tabel Tahun Ajaran</h5>
            <a href="{{ route('admin.tahun-ajaran.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Tahun Ajaran
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tahun Ajaran</th>
                        <th>Total FRS</th>
                        <th>FRS Disetujui</th>
                        <th>Frs Tidak Disetujui</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tahunAjarans as $index => $tahun)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $tahun->nama_tahun_ajaran }}</td>
                            <td>{{ $tahun->total_frs }}</td>
                            <td>{{ $tahun->frs_disetujui }}</td>
                            <td>{{ $tahun->frs_ditolak }}</td>
                            <td>
                                <a href="{{ route('admin.tahun-ajaran.edit', $tahun->id) }}"
                                    class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                <form action="{{ route('admin.tahun-ajaran.destroy', $tahun->id) }}" method="POST"
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
                            <td colspan="5" class="text-center text-muted">Belum ada data tahun ajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
