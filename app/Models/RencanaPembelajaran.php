<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class RencanaPembelajaran extends Model
{
    use HasFactory;
    protected $guarded=[];

    /**
     * Get all of the pelaksanaan_pembelajaran for the Pegawai
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class)->withDefault();
    }
}
