@extends('layouts.admin')

@section('content')
    <h2>Tambah Mahasiswa</h2>
    <p class="text-muted">Isi data lengkap mahasiswa yang ingin ditambahkan</p>

    <div class="card p-4">
        <form action="{{ route('admin.mahasiswa') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" name="nim" id="nim" class="form-control" value="{{ old('nim') }}" required>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="prodi" class="form-label">Program Studi</label>
                <input type="text" name="prodi" id="prodi" class="form-control" value="{{ old('prodi') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status Mahasiswa</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="cuti" {{ old('status') === 'cuti' ? 'selected' : '' }}>Cuti</option>
                    <option value="tidak_aktif" {{ old('status') === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Simpan
            </button>

            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary ms-2">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </form>
    </div>
@endsection
