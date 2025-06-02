<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\TahunAjaran;
use App\Models\MataKuliah;
use App\Models\PaketFrs;
use App\Models\Frs;
use App\Models\FrsMahasiswa;
use App\Models\JadwalKuliah;
use App\Models\Nilai;
use Faker\Factory as Faker;
use Carbon\Carbon;

class BlueCampusSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $ta1 = TahunAjaran::create(['nama_tahun_ajaran' => '2023/2024']);
        $ta2 = TahunAjaran::create(['nama_tahun_ajaran' => '2024/2025']);

        $kelas = Kelas::create([
            'nama_kelas' => 'TI-1A',
            'program_studi' => 'Teknik Informatika',
            'parallel_kelas' => 'A',
        ]);

        for ($i = 1; $i <= 2; $i++) {
            $user = User::create([
                'email' => "admin{$i}@example.com",
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);

            Admin::create([
                'nama' => $faker->name(),
                'alamat' => $faker->address(),
                'no_telepon' => $faker->phoneNumber(),
                'jenis_kelamin' => $faker->randomElement(['pria', 'wanita']),
                'user_id' => $user->id,
            ]);
        }

        $dosenIds = [];
        for ($i = 1; $i <= 11; $i++) {
            $user = User::create([
                'email' => "dosen{$i}@example.com",
                'password' => Hash::make('password'),
                'role' => 'dosen',
            ]);

            $dosen = Dosen::create([
                'nama' => $faker->name(),
                'nip' => '19871231' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'no_telp' => $faker->phoneNumber(),
                'alamat' => $faker->address(),
                'gelar_depan' => $faker->randomElement(['Dr.', 'Ir.', '']),
                'gelar_belakang' => $faker->randomElement(['M.T.', 'S.T., M.Kom', '']),
                'jenis_kelamin' => $faker->randomElement(['pria', 'wanita']),
                'program_studi' => 'Teknik Informatika',
                'user_id' => $user->id,
            ]);

            $dosenIds[] = $dosen->id;
        }

        $matkulIds = [];
        for ($i = 1; $i <= 10; $i++) {
            $matkul = MataKuliah::create([
                'kode_matkul' => 'TI10' . $i,
                'nama' => $faker->words(3, true),
                'jenis_matkul' => $faker->randomElement(['Wajib', 'Pilihan']),
                'sks' => rand(2, 4),
            ]);

            $matkulIds[] = $matkul->id;
        }

        $mahasiswaIds = [];
        for ($i = 1; $i <= 30; $i++) {
            $user = User::create([
                'email' => "mahasiswa{$i}@example.com",
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
            ]);

            $mahasiswa = Mahasiswa::create([
                'nama' => $faker->name(),
                'nrp' => '502520' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'semester' => 4,
                'tanggal_lahir' => $faker->date('Y-m-d', '2005-12-31'),
                'tempat_lahir' => $faker->city(),
                'tanggal_masuk' => '2023-08-01',
                'status' => 'aktif',
                'jenis_kelamin' => $faker->randomElement(['pria', 'wanita']),
                'alamat' => $faker->address(),
                'no_telepon' => $faker->phoneNumber(),
                'asal_sekolah' => $faker->company(),
                'kelas_id' => $kelas->id,
                'dosen_wali_id' => $dosenIds[10], // dosen wali
                'user_id' => $user->id,
            ]);

            $mahasiswaIds[] = $mahasiswa->id;
        }

        $paketFrs = PaketFrs::create([
            'nama_paket' => 'PAKET TI-1A',
            'kelas_id' => $kelas->id,
            'tahun_ajaran_id' => $ta2->id,
        ]);

        $frsIds = [];
        $hariList = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
        for ($i = 0; $i < 10; $i++) {
            $jamMulai = Carbon::createFromTime(8 + ($i % 5) * 2)->format('H:i:s');
            $jamSelesai = Carbon::createFromTime(10 + ($i % 5) * 2)->format('H:i:s');

            $frs = Frs::create([
                'hari' => $hariList[$i % 5],
                'jam_mulai' => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'semester' => 4,
                'kelas' => $kelas->nama_kelas,
                'paket_frs_id' => $paketFrs->id,
                'matkul_id' => $matkulIds[$i],
                'dosen_id' => $dosenIds[$i],
            ]);

            $frsIds[] = $frs->id;

            JadwalKuliah::create([
                'ruangan' => 'R' . ($i + 1),
                'frs_id' => $frs->id,
            ]);
        }

        $frsMahasiswaIds = [];
        foreach ($mahasiswaIds as $mhsId) {
            foreach ($frsIds as $frsId) {
                $frsMhs = FrsMahasiswa::create([
                    'status_disetujui' => 'ya',
                    'catatan' => '-',
                    'mahasiswa_id' => $mhsId,
                    'frs_id' => $frsId,
                ]);
                $frsMahasiswaIds[] = $frsMhs->id;
            }
        }
    }
}