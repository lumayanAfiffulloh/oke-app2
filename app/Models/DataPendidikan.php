<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPendidikan extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function anggaranPendidikan()
    {
        return $this->hasManyThrough(AnggaranPendidikan::class, Jenjang::class);
    }

    public function jenjangs()
    {
        return $this->belongsToMany(Jenjang::class, 'pendidikan_has_jenjangs');
    }

    public function rencanaPembelajaran()
    {
        return $this->hasMany(RencanaPembelajaran::class);
    }

}
