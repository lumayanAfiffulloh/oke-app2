<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        ],
        
        
    ];

    public function posts()
    {
        return $this->hasMany('Post');
    }

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
    public function rencana_pembelajaran(): HasMany
    {
        return $this->hasMany(RencanaPembelajaran::class);
    }
}