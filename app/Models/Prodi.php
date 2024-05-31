<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    // public function registers()
    // {
    //     return $this->hasMany(Register::class);
    // }

    public function jalurMasukProdis()
    {
        return $this->hasMany(JalurMasukProdi::class, 'prodi_id');
    }
}
