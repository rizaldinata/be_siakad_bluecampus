@extends('layouts.admin')

@section('content')
    <h2>Data Nilai Mahasiswa</h2>
    <p class="text-muted">Daftar nilai hasil FRS mahasiswa</p>

    <div class="card p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Tabel Nilai</h5>
            {{-- <a href="{{ route('admin.nilai.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Nilai
            </a> --}}
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Mahasiswa</th>
                        <th>NRP</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>Nilai Angka</th>
                        <th>Nilai Huruf</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($nilais as $index => $nilai)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $nilai->frsMahasiswa->mahasiswa->nama ?? '-' }}</td>
                            <td>{{ $nilai->frsMahasiswa->mahasiswa->nrp ?? '-' }}</td>
                            <td>{{ $nilai->frsMahasiswa->frs->mataKuliah->nama ?? '-' }}</td>
                            <td>{{ $nilai->frsMahasiswa->frs->dosen->nama ?? '-' }}</td>
                            <td>{{ $nilai->nilai_angka ?? 'Belum dinilai' }}</td>
                            <td>{{ $nilai->nilai_huruf ?? 'Belum dinilai' }}</td>
                            <td>
                                {{-- Lihat --}}
                                {{-- <a href="{{ route('admin.nilai.show', $nilai->id) }}" class="btn btn-sm btn-info me-1">
                                    <i class="bi bi-eye-fill"></i>
                                </a> --}}

                                {{-- Edit --}}
                                <a href="{{ route('admin.nilai.edit', $nilai->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.nilai.destroy', $nilai->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus nilai ini?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data nilai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
