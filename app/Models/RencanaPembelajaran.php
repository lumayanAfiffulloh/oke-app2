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
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataPegawai(): BelongsTo
    {
        return $this->belongsTo(DataPegawai::class)->withDefault();
    }
}
