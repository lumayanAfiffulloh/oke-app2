<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function anggaranPendidikan()
    {
        return $this->hasMany(AnggaranPendidikan::class);
    }

    public function anggaranPelatihan()
    {
        return $this->hasMany(AnggaranPelatihan::class);
    }

    public function rencanaPembelajaran()
    {
        return $this->hasMany(RencanaPembelajaran::class);
    }
}
