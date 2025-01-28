<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BentukJalur extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function rencanaPembelajaran()
    {
        return $this->hasMany(RencanaPembelajaran::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    
}
