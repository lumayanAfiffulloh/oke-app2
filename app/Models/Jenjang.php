<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jenjang extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function dataPendidikan()
    {
        return $this->hasMany(DataPendidikan::class);
    }

    public function anggaranPendidikan()
    {
        return $this->hasMany(AnggaranPendidikan::class);
    }

    public function rencanaPendidikan()
    {
        return $this->hasMany(RencanaPembelajaran::class);
    }
}