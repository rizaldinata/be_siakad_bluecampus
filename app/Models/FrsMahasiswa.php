<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrsMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'frs_mahasiswas';

    protected $guarded = [];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    public function frs()
    {
        return $this->belongsTo(Frs::class, 'id_frs');
    }

    public function nilai()
    {
        return $this->hasOne(Nilai::class, 'id_frs_mahasiswa');
    }
}