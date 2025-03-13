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
    public function dataPegawai()
    {
        return $this->belongsTo(DataPegawai::class);
    }
    
    public function dataPendidikan()
    {
        return $this->belongsTo(DataPendidikan::class)->withDefault();
    }

    public function dataPelatihan()
{
        return $this->belongsTo(DataPelatihan::class)->withDefault();
    }

    public function bentukJalur()
    {
        return $this->belongsTo(BentukJalur::class)->withDefault();
    }

    public function jenisPendidikan()
    {
        return $this->belongsTo(JenisPendidikan::class)->withDefault();
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class);
    }

    public function kelompokCanValidating()
    {
        return $this->hasOne(KelompokCanValidating::class, 'rencana_pembelajaran_id');
    }
}
