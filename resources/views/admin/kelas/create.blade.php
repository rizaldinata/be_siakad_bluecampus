@extends('layouts.admin')

@section('content')
    <h2>Tambah Kelas</h2>
    <p class="text-muted">Isi data lengkap Kelas yang ingin ditambahkan</p>

    <div class="card p-4">
        <form action="{{ route('admin.kelas.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="nama_kelas" class="form-label">Nama Kelas</label>
                    <input type="text" name="nama_kelas" id="nama_kelas" class="form-control"
                        value="{{ old('nama_kelas') }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="program_studi" class="form-label">Program Studi</label>
                    <input type="text" name="program_studi" id="program_studi" class="form-control"
                        value="{{ old('program_studi') }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="parallel_kelas" class="form-label">Paralel Kelas</label>
                    <input type="text" name="parallel_kelas" id="parallel_kelas" class="form-control"
                        value="{{ old('parallel_kelas') }}" required>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
