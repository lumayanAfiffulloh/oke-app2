<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nicolaslopezj\Searchable\SearchableTrait;

class DataPegawai extends Model
{
    use HasFactory;

    public function posts()
    {
        return $this->hasMany('Post');
    }

    protected $guarded=[];

    /**
     * Get all of the for the Pegawai
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rencanaPembelajaran()
    {
        return $this->hasMany(RencanaPembelajaran::class);
    }

    public function ketuaKelompok()
    {
        return $this->hasOne(Kelompok::class, 'ketua_id'); // Ketua kelompok
    }

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class)->withDefault();
    }
}
