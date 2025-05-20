<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilais';

    protected $guarded = [];

    public function frsMahasiswa()
    {
        return $this->belongsTo(FrsMahasiswa::class);
    }
}