@extends('layouts.admin')

@section('content')
    <h2>Edit Jadwal Kuliah</h2>
    <p class="text-muted">Perbarui data jadwal kuliah yang telah ada</p>

    <div class="card p-4">
        <form action="{{ route('admin.jadwal-kuliah.update', $jadwal->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Input Ruangan -->
                <div class="mb-3 col-md-6">
                    <label for="ruangan" class="form-label">Ruangan</label>
                    <input type="text" name="ruangan" id="ruangan" class="form-control"
                        value="{{ old('ruangan', $jadwal->ruangan) }}" required>
                </div>

                <!-- Dropdown FRS -->
                <div class="mb-3 col-md-6">
                    <label for="frs_id" class="form-label">Pilih FRS</label>
                    <select name="frs_id" id="frs_id" class="form-select" required>
                        @foreach ($frsList as $frs)
                            <option value="{{ $frs->id }}"
                                {{ old('frs_id', $jadwal->frs_id) == $frs->id ? 'selected' : '' }}>
                                {{ $frs->mataKuliah->nama ?? '-' }} - {{ $frs->dosen->nama ?? '-' }}
                                ({{ ucfirst($frs->hari) }}, {{ $frs->jam_mulai }} - {{ $frs->jam_selesai }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.jadwal-kuliah.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
