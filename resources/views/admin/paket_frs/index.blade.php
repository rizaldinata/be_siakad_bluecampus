@extends('layouts.admin')

@section('content')
    <h2>Data Paket FRS</h2>
    <p class="text-muted">Daftar semua paket FRS yang tersedia</p>

    <div class="card p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Tabel Paket FRS</h5>
            <a href="{{ route('admin.paket-frs.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Paket
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Paket</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($paketFrs as $index => $paket)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $paket->nama_paket }}</td>
                            <td>{{ $paket->kelas->nama_kelas ?? '-' }}</td>
                            <td>
                                {{-- Lihat Detail --}}
                                <a href="{{ route('admin.paket-frs.show', $paket->id) }}" class="btn btn-sm btn-info me-1">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.paket-frs.edit', $paket->id) }}"
                                    class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.paket-frs.destroy', $paket->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus paket ini?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data paket FRS.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
