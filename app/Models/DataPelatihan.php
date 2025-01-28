<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataPelatihan extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function anggaranPelatihan()
    {
        return $this->hasMany(AnggaranPelatihan::class, 'data_pelatihan_id');
    }

    public function rumpun()
    {
        return $this->belongsTo(Rumpun::class);
    }

    public function rencanaPembelajaran()
    {
        return $this->hasMany(RencanaPembelajaran::class);
    }
}
