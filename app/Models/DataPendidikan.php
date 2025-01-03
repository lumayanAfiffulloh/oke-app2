<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPendidikan extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function pendidikanHasEstimasi(): HasMany
    {
        return $this->hasMany(pendidikanHasEstimasi::class, 'data_pendidikan_id');
    }
}
