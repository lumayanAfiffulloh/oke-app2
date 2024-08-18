<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;
    protected $guarded=[];

    /**
     * Get all of the pelaksanaan_pembelajaran for the Pegawai
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pelaksanaan_pembelajaran(): HasMany
    {
        return $this->hasMany(PelaksanaanPembelajaran::class);
    }
}
