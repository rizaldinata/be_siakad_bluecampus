@extends('layouts.admin')

@section('content')
    <h2>Data Jadwal Kuliah</h2>
    <p class="text-muted">Daftar semua jadwal kuliah yang telah ditentukan</p>

    <div class="card p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Tabel Jadwal Kuliah</h5>
            <a href="{{ route('admin.jadwal-kuliah.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Jadwal
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Ruangan</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwalKuliahs as $index => $jadwal)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $jadwal->ruangan }}</td>
                            <td>{{ ucfirst($jadwal->frs->hari) }}</td>
                            <td>{{ $jadwal->frs->jam_mulai }} - {{ $jadwal->frs->jam_selesai }}</td>
                            <td>{{ $jadwal->frs->mataKuliah->nama ?? '-' }}</td>
                            <td>{{ $jadwal->frs->dosen->nama ?? '-' }}</td>
                            <td>{{ $jadwal->frs->paketFrs->kelas->nama_kelas ?? '-' }}</td>
                            <td>
                                {{-- Lihat --}}
                                {{-- <a href="{{ route('admin.jadwal-kuliah.show', $jadwal->id) }}"
                                    class="btn btn-sm btn-info me-1">
                                    <i class="bi bi-eye-fill"></i>
                                </a> --}}

                                {{-- Edit --}}
                                <a href="{{ route('admin.jadwal-kuliah.edit', $jadwal->id) }}"
                                    class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.jadwal-kuliah.destroy', $jadwal->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus jadwal ini?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data jadwal kuliah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
