@extends('layouts.admin')

@section('content')
    <h2>Tambah FRS Mahasiswa</h2>
    <p class="text-muted">Isi data FRS mahasiswa yang ingin ditambahkan</p>

    <div class="card p-4">
        <form action="{{ route('admin.frs-mahasiswa.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Nama Mahasiswa -->
                <div class="mb-3 col-12">
                    <label for="mahasiswa_id" class="form-label">Nama Mahasiswa</label>
                    <select name="mahasiswa_id" id="mahasiswa_id" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Mahasiswa --</option>
                        @foreach ($mahasiswaList as $mhs)
                            <option value="{{ $mhs->id }}" {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
                                {{ $mhs->nama }} ({{ $mhs->nrp }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Mata Kuliah -->
                <div class="mb-3 col-12">
                    <label for="frs_id" class="form-label">Mata Kuliah</label>
                    <select name="frs_id" id="frs_id" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Mata Kuliah --</option>
                        @foreach ($frsList as $frs)
                            <option value="{{ $frs->id }}" {{ old('frs_id') == $frs->id ? 'selected' : '' }}>
                                {{ $frs->mataKuliah->nama ?? '-' }} - {{ ucfirst($frs->hari) }} ({{ $frs->jam_mulai }} -
                                {{ $frs->jam_selesai }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="mb-3 col-12">
                    <label for="status_disetujui" class="form-label">Status</label>
                    <select name="status_disetujui" id="status_disetujui" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Status --</option>
                        @foreach ($statusList as $status)
                            <option value="{{ $status }}"
                                {{ old('status_disetujui') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Catatan -->
                <div class="mb-3 col-12">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea name="catatan" id="catatan" rows="5" class="form-control" placeholder="Masukkan catatan penting...">{{ old('catatan') }}</textarea>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
                <a href="{{ route('admin.frs-mahasiswa.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
