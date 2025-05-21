@extends('layouts.admin')

@section('content')
    <h2>Tambah Mahasiswa</h2>
    <p class="text-muted">Isi data lengkap mahasiswa yang ingin ditambahkan</p>

    <div class="card p-4">
        <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}"
                        required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="nrp" class="form-label">NRP</label>
                    <input type="text" name="nrp" id="nrp" class="form-control" value="{{ old('nrp') }}"
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
                    <label for="semester" class="form-label">Semester</label>
                    <input type="text" name="semester" id="semester" class="form-control" value="{{ old('semester') }}"
                        required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                        value="{{ old('tanggal_lahir') }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                        value="{{ old('tempat_lahir') }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control"
                        value="{{ old('tanggal_masuk') }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="status" class="form-label">Status Mahasiswa</label>
                    <select name="status" id="status" class="form-select">
                        @foreach ($statusList as $status)
                            <option value="{{ $status }}"
                                {{ old('status', $mahasiswa->status ?? '') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
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
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" value="{{ old('alamat') }}"
                        required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="no_telepon" class="form-label">No Telepon</label>
                    <input type="text" name="no_telepon" id="no_telepon" class="form-control"
                        value="{{ old('no_telepon') }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                    <input type="text" name="asal_sekolah" id="asal_sekolah" class="form-control"
                        value="{{ old('asal_sekolah') }}" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="kelas" class="form-label">Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="form-select">
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}"
                                {{ old('kelas_id', $mahasiswa->kelas_id ?? '') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="dosen_wali" class="form-label">Dosen Wali</label>
                    <select name="dosen_wali_id" id="dosen_wali_id" class="form-select">
                        @foreach ($dosenList as $dosen)
                            <option value="{{ $dosen->id }}"
                                {{ old('dosen_wali_id', $mahasiswa->dosen_wali_id ?? '') == $dosen->id ? 'selected' : '' }}>
                                {{ $dosen->nama }}
                            </option>
                        @endforeach
                    </select>

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
