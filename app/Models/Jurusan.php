<?php

namespace App\Models;

use App\Models\Jenjang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jurusan extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function jenjangs()
    {
      return $this->belongsToMany(Jenjang::class, 'data_pendidikans', 'jurusan_id', 'jenjang_id');
    }
}