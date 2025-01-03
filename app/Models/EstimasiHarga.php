<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimasiHarga extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function dataPelatihan()
    {
        return $this->belongsTo(DataPelatihan::class, 'pelatihan_id');
    }
}
