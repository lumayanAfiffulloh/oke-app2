<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rumpun extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function dataPelatihan()
    {
        return $this->hasMany(DataPelatihan::class);
    }
}
