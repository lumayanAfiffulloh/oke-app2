<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawaiCanVerifying extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class);
    }

    public function rencanaPembelajaran()
    {
        return $this->belongsTo(RencanaPembelajaran::class);
    }

    public function catatanVerifikasi()
    {
        return $this->hasMany(CatatanVerifikasi::class, 'kelompok_can_validating_id');
    }
}
