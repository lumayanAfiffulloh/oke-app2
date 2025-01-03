<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataPelatihan extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function estimasiHarga(): HasMany
    {
        return $this->hasMany(EstimasiHarga::class, 'pelatihan_id');
    }
}
