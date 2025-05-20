<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketFrs extends Model
{
    use HasFactory;

    protected $table = 'paket_frs';

    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function frs()
    {
        return $this->hasMany(Frs::class);
    }
}