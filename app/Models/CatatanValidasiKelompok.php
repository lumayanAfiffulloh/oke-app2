<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanValidasiKelompok extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function kelompokCanValidating()
    {
        return $this->belongsTo(kelompokCanValidating::class, 'kelompok_can_validating_id');
    }
}
