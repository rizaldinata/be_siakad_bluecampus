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
        return $this->belongsTo(PaketFrs::class, 'id_paket_frs');
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'id_matkul');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen');
    }

    public function jadwalKuliah()
    {
        return $this->hasOne(JadwalKuliah::class, 'id_frs');
    }

    public function frsMahasiswas()
    {
        return $this->hasMany(FrsMahasiswa::class, 'id_frs');
    }
}