@extends('layouts.admin')

@section('content')
    <h2>Tambah Paket FRS</h2>
    <p class="text-muted">Isi data lengkap paket FRS yang ingin ditambahkan</p>

    <div class="card p-4">
        <form action="{{ route('admin.paket-frs.store') }}" method="POST">
            @csrf
            <div class="row">
                {{-- Nama Paket --}}
                <div class="mb-3 col-md-6">
                    <label for="nama_paket" class="form-label">Nama Paket</label>
                    <input type="text" name="nama_paket" id="nama_paket" class="form-control"
                        value="{{ old('nama_paket') }}" required>
                </div>

                {{-- Kelas --}}
                <div class="mb-3 col-md-6">
                    <label for="kelas_id" class="form-label">Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="form-select" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tahun Ajaran --}}
                <div class="mb-3 col-md-6">
                    <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                    <select name="tahun_ajaran_id" id="tahun_ajaran_id" class="form-select" required>
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        @foreach ($tahunAjaranList as $tahun)
                            <option value="{{ $tahun->id }}"
                                {{ old('tahun_ajaran_id') == $tahun->id ? 'selected' : '' }}>
                                {{ $tahun->nama_tahun_ajaran }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
                <a href="{{ route('admin.paket-frs.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
