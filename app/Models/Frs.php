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
        return $this->belongsTo(PaketFrs::class);
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'matkul_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function jadwalKuliah() 
    {
        return $this->hasOne(JadwalKuliah::class);
    }

    public function frsMahasiswas()
    {
        return $this->hasMany(FrsMahasiswa::class);
    }
}