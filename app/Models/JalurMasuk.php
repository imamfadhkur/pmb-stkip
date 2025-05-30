<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JalurMasuk extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function registers()
    {
        return $this->hasMany(Register::class);
    }
}
