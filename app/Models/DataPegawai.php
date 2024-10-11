<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nicolaslopezj\Searchable\SearchableTrait;

class DataPegawai extends Model
{
    use HasFactory;
    use SearchableTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'data_pegawais.nama' => 1,
            'data_pegawais.unit_kerja' => 1,
            'data_pegawais.nip' => 1,
        ],
        
        
    ];

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
