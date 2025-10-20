<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanVerifikasi extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function unitKerjaCanVerifying()
    {
        return $this->belongsTo(unitKerjaCanVerifying::class, 'unit_kerja_can_verifying_id');
    }
}
