<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pendidikanHasEstimasi extends Model
{
    use HasFactory;

    public function dataPendidikan()
    {
        return $this->belongsTo(DataPendidikan::class, 'data_pendidikan_id');
    }
    public function estimasiPendidikan()
    {
        return $this->belongsTo(EstimasiPendidikan::class, 'estimasi_pendidikan_id');
    }
}
