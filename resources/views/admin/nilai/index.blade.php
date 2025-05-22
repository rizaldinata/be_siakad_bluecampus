@extends('layouts.admin')

@section('content')
    <h2>Data Nilai Mahasiswa</h2>
    <p class="text-muted">Daftar nilai dari FRS yang telah disetujui</p>

    {{-- Sudah Dinilai --}}
    <div class="card p-4 mb-4">
        <h5 class="mb-3">FRS Mahasiswa yang Sudah Dinilai</h5>
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
                    @forelse ($frsDisetujuiDenganNilai as $index => $frsMhs)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $frsMhs->mahasiswa->nama }}</td>
                            <td>{{ $frsMhs->mahasiswa->nrp }}</td>
                            <td>{{ $frsMhs->frs->mataKuliah->nama ?? '-' }}</td>
                            <td>{{ $frsMhs->frs->dosen->nama ?? '-' }}</td>
                            <td>{{ $frsMhs->nilai->nilai_angka }}</td>
                            <td>{{ $frsMhs->nilai->nilai_huruf }}</td>
                            <td>
                                <a href="{{ route('admin.nilai.edit', $frsMhs->nilai->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada nilai yang diberikan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Belum Dinilai --}}
    <div class="card p-4">
        <h5 class="mb-3">FRS Mahasiswa yang Belum Dinilai</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Mahasiswa</th>
                        <th>NRP</th>
                        <th>Mata Kuliah</th>
                        <th>Dosen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($frsDisetujuiTanpaNilai as $index => $frsMhs)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $frsMhs->mahasiswa->nama }}</td>
                            <td>{{ $frsMhs->mahasiswa->nrp }}</td>
                            <td>{{ $frsMhs->frs->mataKuliah->nama ?? '-' }}</td>
                            <td>{{ $frsMhs->frs->dosen->nama ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.nilai.create', ['frs_mahasiswa_id' => $frsMhs->id]) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-circle"></i> Beri Nilai
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Semua FRS sudah dinilai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
