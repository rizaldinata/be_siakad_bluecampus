@extends('layouts.admin')

@section('content')
    <h2>Tambah Jadwal Kuliah</h2>
    <p class="text-muted">Isi data jadwal kuliah yang ingin ditambahkan</p>

    <div class="card p-4">
        <form action="{{ route('admin.jadwal-kuliah.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Input Ruangan -->
                <div class="mb-3 col-md-6">
                    <label for="ruangan" class="form-label">Ruangan</label>
                    <input type="text" name="ruangan" id="ruangan" class="form-control" value="{{ old('ruangan') }}"
                        required>
                </div>

                <!-- Dropdown FRS -->
                <div class="mb-3 col-md-6">
                    <label for="frs_id" class="form-label">Pilih FRS</label>
                    <select name="frs_id" id="frs_id" class="form-select" required>
                        <option value="" disabled selected>-- Pilih salah satu --</option>
                        @foreach ($frsList as $frs)
                            <option value="{{ $frs->id }}" {{ old('frs_id') == $frs->id ? 'selected' : '' }}>
                                {{ $frs->mataKuliah->nama ?? '-' }} - {{ $frs->dosen->nama ?? '-' }}
                                ({{ ucfirst($frs->hari) }}, {{ $frs->jam_mulai }} - {{ $frs->jam_selesai }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
                <a href="{{ route('admin.jadwal-kuliah.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
