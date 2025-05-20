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
        return $this->belongsTo(Mahasiswa::class);
    }

    public function frs()
    {
        return $this->belongsTo(Frs::class);
    }

    public function nilai()
    {
        return $this->hasOne(Nilai::class);
    }
}