<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenjangTerakhir extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function pendidikanTerakhir()
    {
        return $this->hasMany(PendidikanTerakhir::class);
    }
}
