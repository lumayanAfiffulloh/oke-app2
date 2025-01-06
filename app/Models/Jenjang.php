<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jenjang extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function jurusans()
    {
      return $this->belongsToMany(Jurusan::class, 'data_pendidikans', 'jenjang_id', 'jurusan_id');
    }
}