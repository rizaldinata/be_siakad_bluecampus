@extends('layouts.admin')

@section('content')
    <h2>Tambah Dosen</h2>
    <p class="text-muted">Isi data lengkap Dosen yang ingin ditambahkan</p>

    <div class="card p-4">
        <form action="{{ route('admin.dosen.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}"
                        required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" name="nip" id="nip" class="form-control" value="{{ old('nip') }}"
                        required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}"
                        required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}"
                        required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="gelar_depan" class="form-label">Gelar Depan</label>
                    <input type="text" name="gelar_depan" id="gelar_depan" class="form-control"
                        value="{{ old('gelar_depan') }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="gelar_belakang" class="form-label">Gelar Belakang</label>
                    <input type="text" name="gelar_belakang" id="gelar_belakang" class="form-control"
                        value="{{ old('gelar_belakang') }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="no_telp" class="form-label">No Telepon</label>
                    <input type="text" name="no_telp" id="no_telp" class="form-control" value="{{ old('no_telp') }}"
                        required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" value="{{ old('alamat') }}"
                        required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                        @foreach ($jenisKelaminList as $jk)
                            <option value="{{ $jk }}"
                                {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin ?? '') == $jk ? 'selected' : '' }}>
                                {{ ucfirst($jk) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="program_studi" class="form-label">Program Studi</label>
                    <input type="text" name="program_studi" id="program_studi" class="form-control"
                        value="{{ old('program_studi') }}" required>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
                <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
