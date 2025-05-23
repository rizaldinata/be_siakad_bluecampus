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
        return $this->hasMany(Frs::class, 'tahun_ajaran_id');
    }
}