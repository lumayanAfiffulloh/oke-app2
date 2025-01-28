<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggaranPelatihan extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function dataPelatihan()
    {
        return $this->belongsTo(DataPelatihan::class, 'data_pelatihan_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
