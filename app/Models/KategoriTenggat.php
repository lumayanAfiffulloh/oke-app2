<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriTenggat extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function tenggatRencana()
    {
        return $this->hasMany(TenggatRencana::class);
    }
}
