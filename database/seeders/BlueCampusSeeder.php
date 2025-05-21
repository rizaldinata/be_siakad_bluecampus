<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BlueCampusSeeder extends Seeder
{
    public function run()
    {
        // Insert Users
        DB::table('users')->insert([
            ['id' => 1, 'email' => 'admin@example.com', 'role' => 'admin', 'password' => Hash::make('password')],
            ['id' => 2, 'email' => 'dosen@example.com', 'role' => 'dosen', 'password' => Hash::make('password')],
            ['id' => 3, 'email' => 'mahasiswa@example.com', 'role' => 'mahasiswa', 'password' => Hash::make('password')],
        ]);

        // Insert Kelas
        DB::table('kelas')->insert([
            'id' => 1,
            'nama_kelas' => 'TI-1A',
            'program_studi' => 'Teknik Informatika',
            'parallel_kelas' => 'A',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Mata Kuliah
        DB::table('mata_kuliahs')->insert([
            'id' => 1,
            'kode_matkul' => 'TI101',
            'nama' => 'Pemrograman Dasar',
            'jenis_matkul' => 'Wajib',
            'sks' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Admin
        DB::table('admins')->insert([
            'id' => 1,
            'nama' => 'Admin Utama',
            'alamat' => 'Gang Rajawali Barat No. 509, Bau-Bau',
            'no_telepon' => '0856775150',
            'jenis_kelamin' => 'pria',
            'id_users' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Dosen
        DB::table('dosens')->insert([
            'id' => 1,
            'nama' => 'Dosen Satu',
            'nip' => '198712312022041001',
            'no_telp' => '0898775641',
            'alamat' => 'Jl. W.R. Supratman No. 48, Jakarta Selatan',
            'gelar_depan' => 'Dr.',
            'gelar_belakang' => 'S.T., M.Kom',
            'jenis_kelamin' => 'pria',
            'program_studi' => 'Teknik Informatika',
            'users_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Mahasiswa
        DB::table('mahasiswas')->insert([
            'id' => 1,
            'nama' => 'Mahasiswa Satu',
            'nrp' => '5025201234',
            'semester' => 4,
            'tanggal_lahir' => '2004-04-20',
            'tempat_lahir' => 'Surabaya',
            'tanggal_masuk' => '2022-08-01',
            'status' => 'aktif',
            'jenis_kelamin' => 'wanita',
            'alamat' => 'Jl. Kutai No. 056, Malang',
            'no_telepon' => '080685705',
            'asal_sekolah' => 'SMA Negeri 1 Surabaya',
            'kelas_id' => 1,
            'dosen_wali_id' => 1,
            'users_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Paket FRS
        DB::table('paket_frs')->insert([
            'id' => 1,
            'nama_paket' => 'PAKET 1',
            'kelas_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // FRS
        DB::table('frs')->insert([
            'id' => 1,
            'hari' => 'senin',
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '09:40:00',
            'semester' => 4,
            'kelas' => 'TI-1A',
            'paket_frs_id' => 1,
            'matkul_id' => 1,
            'dosen_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // FRS Mahasiswa
        DB::table('frs_mahasiswas')->insert([
            'id' => 1,
            'status_disetujui' => 'ya',
            'catatan' => '-',
            'mahasiswa_id' => 1,
            'frs_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Jadwal Kuliah
        DB::table('jadwal_kuliahs')->insert([
            'id' => 1,
            'ruangan' => 'D401',
            'frs_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Nilai
        DB::table('nilais')->insert([
            'id' => 1,
            'nilai_angka' => 85,
            'nilai_huruf' => 'A',
            'frs_mahasiswa_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}