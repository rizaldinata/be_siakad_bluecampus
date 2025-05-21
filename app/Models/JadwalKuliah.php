<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kuliahs';

    protected $guarded = [];

    public function frs()
    {
        return $this->belongsTo(Frs::class, 'id_frs');
    }
}