@extends('layouts.admin')

@section('content')
    <h2>Edit FRS Mahasiswa</h2>
    <p class="text-muted">Perbarui status dan catatan FRS mahasiswa</p>

    <div class="card p-4">
        <form action="{{ route('admin.frs-mahasiswa.update', $frsMahasiswa->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Nama Mahasiswa (readonly) -->
                <div class="mb-3 col-12">
                    <label class="form-label">Nama Mahasiswa</label>
                    <input type="text" class="form-control bg-light"
                        value="{{ $frsMahasiswa->mahasiswa->nama }} ({{ $frsMahasiswa->mahasiswa->nrp }})" disabled>
                </div>

                <!-- Mata Kuliah (readonly) -->
                <div class="mb-3 col-12">
                    <label class="form-label">Mata Kuliah</label>
                    <input type="text" class="form-control bg-light"
                        value="{{ $frsMahasiswa->frs->mataKuliah->nama ?? '-' }} - {{ ucfirst($frsMahasiswa->frs->hari) }} ({{ $frsMahasiswa->frs->jam_mulai }} - {{ $frsMahasiswa->frs->jam_selesai }})"
                        disabled>
                </div>

                <!-- Status -->
                <div class="mb-3 col-12">
                    <label for="status_disetujui" class="form-label">Status</label>
                    <select name="status_disetujui" id="status_disetujui" class="form-select">
                        @foreach ($statusList as $status)
                            <option value="{{ $status }}"
                                {{ old('status_disetujui', $frsMahasiswa->status_disetujui) == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Catatan -->
                <div class="mb-3 col-12">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea name="catatan" id="catatan" rows="5" class="form-control" required>{{ old('catatan', $frsMahasiswa->catatan) }}</textarea>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.frs-mahasiswa.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
