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
        return $this->hasOne(User::class, 'users_id');
    }

    public function frs()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}