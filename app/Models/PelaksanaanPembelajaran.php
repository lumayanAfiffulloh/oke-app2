<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PelaksanaanPembelajaran extends Model
{
    use HasFactory;
    protected $guarded =[];

    /**
     * Get the pegawai that owns the PelaksanaanPembelajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class)->withDefault();
    }
    
    public function rencana_pembelajaran(): BelongsTo
    {
        return $this->belongsTo(RencanaPembelajaran::class)->withDefault();
    }
}
