<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstimasiPendidikan extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function pendidikanHasEstimasi(): HasMany
    {
        return $this->hasMany(pendidikanHasEstimasi::class, 'estimasi_pendidikan_id');
    }

}
