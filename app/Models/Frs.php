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

    public function tahunAjaran()
    {
        return $this->hasOneThrough(
            TahunAjaran::class,
            PaketFrs::class,
            'id',                // foreign key di PaketFrs
            'id',                // primary key di TahunAjaran
            'paket_frs_id',      // foreign key di FRS
            'tahun_ajaran_id'    // foreign key di PaketFrs
        );
    }
}