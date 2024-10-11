<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelompok extends Model
{
  use HasFactory;

  protected $guarded=[];

	public function ketua(): BelongsTo
	{
		return $this->belongsTo(DataPegawai::class, 'ketua_id');
	}

	public function anggota(): HasMany
	{
		return $this->hasMany(DataPegawai::class, 'kelompok_id');
	}

}
