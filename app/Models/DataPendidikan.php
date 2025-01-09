<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPendidikan extends Model
{
    use HasFactory;
    protected $guarded=[];

    // Relasi ke Jenjang
    public function jenjangs()
    {
        return $this->belongsToMany(Jenjang::class, 'pendidikan_has_jenjangs', 'data_pendidikan_id', 'jenjang_id'); 
    }

    public function anggaranPendidikan()
    {
        return $this->hasManyThrough(AnggaranPendidikan::class, Jenjang::class);
    }
    // Relasi ke Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
