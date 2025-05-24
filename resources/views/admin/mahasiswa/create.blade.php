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
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                        required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
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
                    <div class="form-text">Hanya diperbolehkan masuk pada bulan 6–12 (semester ganjil).</div>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="semester" class="form-label">Semester (otomatis)</label>
                    <input type="text" id="semester" class="form-control bg-light" disabled>
                    <input type="hidden" name="semester" id="semester_hidden">
                    <div class="form-text text-danger" id="semesterWarning" style="display: none;">
                        Tanggal masuk hanya diizinkan pada semester ganjil (bulan Juni–Desember).
                    </div>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="status" class="form-label">Status Mahasiswa</label>
                    <select name="status" id="status" class="form-select">
                        @foreach ($statusList as $status)
                            <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                        @foreach ($jenisKelaminList as $jk)
                            <option value="{{ $jk }}" {{ old('jenis_kelamin') == $jk ? 'selected' : '' }}>
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
                    <label for="kelas_id" class="form-label">Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="form-select">
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="dosen_wali_id" class="form-label">Dosen Wali</label>
                    <select name="dosen_wali_id" id="dosen_wali_id" class="form-select">
                        @foreach ($dosenList as $dosen)
                            <option value="{{ $dosen->id }}"
                                {{ old('dosen_wali_id') == $dosen->id ? 'selected' : '' }}>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalMasukInput = document.getElementById('tanggal_masuk');
            const semesterInput = document.getElementById('semester');
            const semesterHidden = document.getElementById('semester_hidden');
            const semesterWarning = document.getElementById('semesterWarning');

            tanggalMasukInput.addEventListener('change', function() {
                const tanggalMasuk = new Date(this.value);
                if (isNaN(tanggalMasuk)) return;

                const sekarang = new Date();
                const bulanMasuk = tanggalMasuk.getMonth() + 1;

                if (bulanMasuk >= 6 && bulanMasuk <= 12) {
                    const selisihBulan = (sekarang.getFullYear() - tanggalMasuk.getFullYear()) * 12 +
                        (sekarang.getMonth() - tanggalMasuk.getMonth());
                    let semester = Math.ceil(selisihBulan / 6);
                    semester = Math.min(Math.max(semester, 1), 8);

                    semesterInput.value = semester;
                    semesterHidden.value = semester;
                    semesterWarning.style.display = 'none';
                } else {
                    semesterInput.value = '';
                    semesterHidden.value = '';
                    semesterWarning.style.display = 'block';
                }
            });
        });
    </script>
@endsection
