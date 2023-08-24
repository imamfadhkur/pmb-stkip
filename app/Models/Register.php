<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function pilihan1Prodi()
    {
        return $this->belongsTo(Prodi::class, 'pilihan1');
    }

    public function pilihan2Prodi()
    {
        return $this->belongsTo(Prodi::class, 'pilihan2');
    }

    public function pilihan3Prodi()
    {
        return $this->belongsTo(Prodi::class, 'pilihan3');
    }

    public function diterimadi()
    {
        return $this->belongsTo(Prodi::class, 'diterima_di');
    }

    // public function diterima_di()
    // {
    //     return $this->belongsTo(Prodi::class);
    // }

    public function jenjangPendidikan()
    {
        return $this->belongsTo(JenjangPendidikan::class);
    }

    public function sistemKuliah()
    {
        return $this->belongsTo(SistemKuliah::class);
    }

    public function jalurMasuk()
    {
        return $this->belongsTo(JalurMasuk::class);
    }
}
