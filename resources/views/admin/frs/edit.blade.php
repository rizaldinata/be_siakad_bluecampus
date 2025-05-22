@extends('layouts.admin')

@section('content')
    <h2>Edit Data FRS</h2>
    <p class="text-muted">Perbarui data FRS sesuai kebutuhan</p>

    <div class="card p-4">
        <form action="{{ route('admin.frs.update', $frs->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="hari" class="form-label">Hari</label>
                    <select name="hari" id="hari" class="form-select" required>
                        @foreach ($hariList as $hari)
                            <option value="{{ $hari }}" {{ old('hari', $frs->hari) == $hari ? 'selected' : '' }}>
                                {{ ucfirst($hari) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-md-3">
                    <label for="jam_mulai" class="form-label">Jam Mulai</label>
                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control"
                        value="{{ old('jam_mulai', $frs->jam_mulai) }}" required>
                </div>

                <div class="mb-3 col-md-3">
                    <label for="jam_selesai" class="form-label">Jam Selesai</label>
                    <input type="time" name="jam_selesai" id="jam_selesai" class="form-control"
                        value="{{ old('jam_selesai', $frs->jam_selesai) }}" required>
                </div>

                <div class="mb-3 col-md-4">
                    <label for="semester" class="form-label">Semester</label>
                    <input type="number" name="semester" id="semester" class="form-control"
                        value="{{ old('semester', $frs->semester) }}" required>
                </div>

                <div class="mb-3 col-md-4">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input type="text" name="kelas" id="kelas" class="form-control"
                        value="{{ old('kelas', $frs->kelas) }}" required>
                </div>

                <div class="mb-3 col-md-4">
                    <label for="paket_frs_id" class="form-label">Paket FRS</label>
                    <select name="paket_frs_id" id="paket_frs_id" class="form-select" required>
                        @foreach ($paketFrs as $paket)
                            <option value="{{ $paket->id }}"
                                {{ old('paket_frs_id', $frs->paket_frs_id) == $paket->id ? 'selected' : '' }}>
                                {{ $paket->nama_paket }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="matkul_id" class="form-label">Mata Kuliah</label>
                    <select name="matkul_id" id="matkul_id" class="form-select" required>
                        @foreach ($mataKuliahs as $matkul)
                            <option value="{{ $matkul->id }}"
                                {{ old('matkul_id', $frs->matkul_id) == $matkul->id ? 'selected' : '' }}>
                                {{ $matkul->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="dosen_id" class="form-label">Dosen</label>
                    <select name="dosen_id" id="dosen_id" class="form-select" required>
                        @foreach ($dosens as $dosen)
                            <option value="{{ $dosen->id }}"
                                {{ old('dosen_id', $frs->dosen_id) == $dosen->id ? 'selected' : '' }}>
                                {{ $dosen->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.frs.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
