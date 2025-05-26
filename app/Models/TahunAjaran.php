<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajarans';

    protected $guarded = [];

    public function frs()
    {
        return $this->hasMany(PaketFrs::class, 'tahun_ajaran_id');
    }

    public function frsLangsung()
    {
        return $this->hasManyThrough(
            \App\Models\Frs::class,
            \App\Models\PaketFrs::class,
            'tahun_ajaran_id',  // foreign key di PaketFrs
            'paket_frs_id',     // foreign key di Frs
            'id',               // primary key di TahunAjaran
            'id'                // primary key di PaketFrs
        );
    }
}