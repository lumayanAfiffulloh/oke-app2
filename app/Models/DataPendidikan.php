<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPendidikan extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function estimasiPendidikans()
    {
        return $this->belongsToMany(EstimasiPendidikan::class, 'pendidikan_has_estimasis');
    }

    // Relasi ke Jenjang
    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }

    // Relasi ke Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
