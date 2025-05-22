@extends('layouts.admin')

@section('content')
    <h2>Data FRS Mahasiswa</h2>
    <p class="text-muted">Daftar pengambilan FRS oleh mahasiswa</p>

    <div class="card p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Tabel FRS Mahasiswa</h5>
            <a href="{{ route('admin.frs-mahasiswa.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah FRS Mahasiswa
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>NRP</th>
                        <th>Nama Mahasiswa</th>
                        <th>Dosen Wali</th>
                        <th>Mata Kuliah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($frsMahasiswas as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->mahasiswa->nrp ?? '-' }}</td>
                            <td>{{ $item->mahasiswa->nama ?? '-' }}</td>
                            <td>{{ $item->mahasiswa->dosenWali->nama ?? '-' }}</td>
                            <td>{{ $item->frs->mataKuliah->nama ?? '-' }}</td>
                            <td>
                                @if ($item->status_disetujui === 'ya')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif ($item->status_disetujui === 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif ($item->status_disetujui === 'tidak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                {{-- Lihat --}}
                                <a href="{{ route('admin.frs-mahasiswa.show', $item->id) }}"
                                    class="btn btn-sm btn-info me-1">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.frs-mahasiswa.edit', $item->id) }}"
                                    class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.frs-mahasiswa.destroy', $item->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data FRS Mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
