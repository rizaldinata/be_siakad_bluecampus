@extends('layouts.admin')

@section('content')
    <h2>Tambah Nilai Mahasiswa</h2>
    <p class="text-muted">Masukkan nilai mahasiswa berdasarkan FRS yang diambil</p>

    <div class="card p-4">
        <form action="{{ route('admin.nilai.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6 d-flex flex-column gap-3">
                    <!-- Pilih Mahasiswa -->
                    <div>
                        <label for="frs_mahasiswa_id" class="form-label">Mahasiswa - Mata Kuliah</label>
                        <select name="frs_mahasiswa_id" id="frs_mahasiswa_id" class="form-select" required>
                            <option value="" disabled selected>-- Pilih Mahasiswa & Mata Kuliah --</option>
                            @foreach ($frsMahasiswas as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('frs_mahasiswa_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->mahasiswa->nama ?? '-' }} - {{ $item->frs->mataKuliah->nama ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nilai Angka -->
                    <div>
                        <label for="nilai_angka" class="form-label">Nilai Angka</label>
                        <input type="number" name="nilai_angka" id="nilai_angka" class="form-control"
                            value="{{ old('nilai_angka') }}" min="0" max="100" required>
                    </div>

                    <!-- Preview Nilai Huruf -->
                    <div>
                        <label class="form-label">Nilai Huruf (Otomatis)</label>
                        <input type="text" class="form-control bg-light" id="nilai_huruf_preview" readonly>
                    </div>
                </div>

                <!-- Kolom Kanan (Panduan Konversi) -->
                <div class="col-md-6">
                    <div class="border rounded p-3 h-100 bg-light">
                        <h6 class="fw-bold">Panduan Konversi</h6>
                        <ul class="mb-0 small">
                            <li>86 - 100 → A</li>
                            <li>81 - &lt;86 → A–</li>
                            <li>76 - &lt;81 → AB</li>
                            <li>71 - &lt;76 → B+</li>
                            <li>66 - &lt;71 → B</li>
                            <li>61 - &lt;66 → BC</li>
                            <li>56 - &lt;61 → C</li>
                            <li>41 - &lt;56 → D</li>
                            <li>0 - &lt;41 → E</li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
                <a href="{{ route('admin.nilai.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>

    <!-- Script Real-Time Konversi Nilai -->
    <script>
        document.getElementById('nilai_angka').addEventListener('input', function() {
            const angka = parseFloat(this.value);
            let huruf = '';

            if (angka >= 86 && angka <= 100) huruf = 'A';
            else if (angka >= 81) huruf = 'A-';
            else if (angka >= 76) huruf = 'AB';
            else if (angka >= 71) huruf = 'B+';
            else if (angka >= 66) huruf = 'B';
            else if (angka >= 61) huruf = 'BC';
            else if (angka >= 56) huruf = 'C';
            else if (angka >= 41) huruf = 'D';
            else if (angka >= 0) huruf = 'E';

            document.getElementById('nilai_huruf_preview').value = huruf;
        });
    </script>
@endsection
