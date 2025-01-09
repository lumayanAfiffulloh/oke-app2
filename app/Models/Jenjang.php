<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jenjang extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function dataPendidikans()
    {
        return $this->belongsToMany(DataPendidikan::class, 'pendidikan_has_jenjangs', 'jenjang_id', 'data_pendidikan_id');
    }

    public function anggaranPendidikan()
    {
        return $this->hasMany(AnggaranPendidikan::class);
    }
}