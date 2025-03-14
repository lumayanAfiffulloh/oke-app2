<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendidikanTerakhir extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function dataPegawai()
    {
        return $this->hasMany(DataPegawai::class);
    }
    
    public function jenjangTerakhir()
    {
        return $this->belongsTo(JenjangTerakhir::class);
    }
}
