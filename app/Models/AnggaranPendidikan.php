<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnggaranPendidikan extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function jenjangs()
    {
        return $this->belongsTo(Jenjang::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

}
