<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frs extends Model
{
    use HasFactory;

    protected $table = 'frs';

    protected $guarded = [];

    public function paketFrs()
    {
        return $this->belongsTo(PaketFrs::class, 'paket_frs_id');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'matkul_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function jadwalKuliah()
    {
        return $this->hasOne(JadwalKuliah::class, 'frs_id');
    }

    public function frsMahasiswas()
    {
        return $this->hasMany(FrsMahasiswa::class, 'frs_id');
    }
}