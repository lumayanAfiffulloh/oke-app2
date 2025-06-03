<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanVerifikasi extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pegawaiCanVerifying()
    {
        return $this->belongsTo(pegawaiCanVerifying::class, 'pegawai_can_verifying_id');
    }
}
