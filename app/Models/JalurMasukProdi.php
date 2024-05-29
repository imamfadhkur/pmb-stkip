<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JalurMasukProdi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function prodis()
    {
        return $this->hasMany(Prodi::class, 'prodi_id', 'id');
    }

    public function jalur_masuks()
    {
        return $this->hasMany(JalurMasuk::class, 'jalur_masuk_id', 'id');
    }
}
