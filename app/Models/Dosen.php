<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosens';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function frs()
    {
        return $this->hasMany(Frs::class, 'dosen_id');
    }

    public function getNamaLengkapAttribute()
    {
        $gelarDepan = $this->gelar_depan ? $this->gelar_depan . ' ' : '';
        $gelarBelakang = $this->gelar_belakang ? ', ' . $this->gelar_belakang : '';

        return $gelarDepan . $this->nama . $gelarBelakang;
    }
}