@extends('layouts.admin')

@section('content')
    <h2>Edit Paket FRS</h2>
    <p class="text-muted">Perbarui data paket FRS sesuai kebutuhan</p>

    <div class="card p-4">
        <form action="{{ route('admin.paket-frs.update', $paketFrs->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Nama Paket --}}
                <div class="mb-3 col-md-6">
                    <label for="nama_paket" class="form-label">Nama Paket</label>
                    <input type="text" name="nama_paket" id="nama_paket" class="form-control"
                        value="{{ old('nama_paket', $paketFrs->nama_paket) }}" required>
                </div>

                {{-- Kelas --}}
                <div class="mb-3 col-md-6">
                    <label for="kelas_id" class="form-label">Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="form-select" required>
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}"
                                {{ old('kelas_id', $paketFrs->kelas_id) == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tahun Ajaran --}}
                <div class="mb-3 col-md-6">
                    <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                    <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-select" required>
                        @foreach ($tahunAjaranList as $tahun)
                            <option value="{{ $tahun->id }}"
                                {{ old('tahun_ajaran_id', $paketFrs->tahun_ajaran_id) == $tahun->id ? 'selected' : '' }}>
                                {{ $tahun->nama_tahun_ajaran }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.paket-frs.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
