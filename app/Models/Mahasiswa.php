<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswas';

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'users_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function dosenWali()
    {
        return $this->belongsTo(Dosen::class, 'dosen_wali_id');
    }

    public function frsMahasiswa()
    {
        return $this->hasMany(FrsMahasiswa::class, 'frs_mahasiswa_id');
    }

    public function frs()
    {
        return $this->belongsToMany(Frs::class, 'frs_mahasiswas', 'mahasiswa_id', 'frs_id')
            ->withPivot('status_disetujui', 'catatan');
    }
}