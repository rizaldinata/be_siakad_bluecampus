@extends('layouts.admin')

@section('content')
    <h2>Edit Mata Kuliah</h2>
    <p class="text-muted">Perbarui data mata kuliah sesuai kebutuhan</p>

    <div class="card p-4">
        <form action="{{ route('admin.mata-kuliah.update', $mataKuliah->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="kode_matkul" class="form-label">Kode Matkul</label>
                    <input type="text" name="kode_matkul" id="kode_matkul" class="form-control"
                        value="{{ old('kode_matkul', $mataKuliah->kode_matkul) }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="nama" class="form-label">Nama Matkul</label>
                    <input type="text" name="nama" id="nama" class="form-control"
                        value="{{ old('nama', $mataKuliah->nama) }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="jenis_matkul" class="form-label">Jenis Matkul</label>
                    <input type="text" name="jenis_matkul" id="jenis_matkul" class="form-control"
                        value="{{ old('jenis_matkul', $mataKuliah->jenis_matkul) }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="sks" class="form-label">SKS</label>
                    <input type="text" name="sks" id="sks" class="form-control"
                        value="{{ old('sks', $mataKuliah->sks) }}" required>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.mata-kuliah.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
