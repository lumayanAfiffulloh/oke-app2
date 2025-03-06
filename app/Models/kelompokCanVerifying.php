<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelompokCanVerifying extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class);
    }

    public function rencanaPembelajaran()
    {
        return $this->belongsTo(RencanaPembelajaran::class);
    }
}
