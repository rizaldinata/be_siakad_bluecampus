@extends('layouts.admin')

@section('content')
    <h2>Tambah Tahun Ajaran</h2>
    <p class="text-muted">Isi tahun awal, tahun akhir akan ditentukan otomatis.</p>

    <div class="card p-4">
        <form action="{{ route('admin.tahun-ajaran.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="tahun_awal" class="form-label">Tahun Awal</label>
                    <input type="number" name="tahun_awal" id="tahun_awal" class="form-control"
                        value="{{ old('tahun_awal') }}" required min="2000" max="2099" oninput="updatePreview()">
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label">Preview Tahun Ajaran</label>
                    <input type="text" class="form-control bg-light" id="tahun_ajaran_preview" readonly>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
                <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </form>
    </div>

    <script>
        function updatePreview() {
            const input = document.getElementById('tahun_awal');
            const preview = document.getElementById('tahun_ajaran_preview');

            if (input.value) {
                const tahunAwal = parseInt(input.value);
                const tahunAkhir = tahunAwal + 1;
                preview.value = `${tahunAwal}/${tahunAkhir}`;
            } else {
                preview.value = '';
            }
        }

        window.onload = updatePreview;
    </script>
@endsection
