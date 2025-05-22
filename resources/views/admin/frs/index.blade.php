@extends('layouts.admin')

@section('content')
    <h2>Data FRS</h2>
    <p class="text-muted">Daftar semua jadwal FRS yang terdaftar</p>

    <div class="card p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Tabel FRS</h5>
            <a href="{{ route('admin.frs.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah FRS
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Semester</th>
                        <th>Kelas</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>Paket FRS</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($frsList as $index => $frs)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-capitalize">{{ $frs->hari }}</td>
                            <td>{{ \Carbon\Carbon::parse($frs->jam_mulai)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($frs->jam_selesai)->format('H:i') }}</td>
                            <td>{{ $frs->semester }}</td>
                            <td>{{ $frs->kelas }}</td>
                            <td>{{ $frs->mataKuliah->nama ?? '-' }}</td>
                            <td>{{ $frs->dosen->nama ?? '-' }}</td>
                            <td>{{ $frs->paketFrs->nama_paket ?? '-' }}</td>
                            <td>
                                {{-- Lihat Detail --}}
                                <a href="{{ route('admin.frs.show', $frs->id) }}" class="btn btn-sm btn-info me-1">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.frs.edit', $frs->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.frs.destroy', $frs->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus data FRS ini?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada data FRS.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
