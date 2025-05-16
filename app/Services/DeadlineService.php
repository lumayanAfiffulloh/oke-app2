<?php
namespace App\Services;

use App\Models\KategoriTenggat;
use App\Models\TenggatRencana;
use Carbon\Carbon;

class DeadlineService
{
    public function getDeadlineInfo($kategoriTenggat)
    {
        $kategori = KategoriTenggat::where('kategori_tenggat', $kategoriTenggat)->first();

        if (!$kategori) {
            return [
                'is_within_deadline' => false,
                'start_date' => null,
                'end_date' => null
            ];
        }

        $tenggat = TenggatRencana::where('kategori_tenggat_id', $kategori->id)->first();

        if (!$tenggat) {
            return [
                'is_within_deadline' => false,
                'start_date' => null,
                'end_date' => null
            ];
        }

        $now = Carbon::now();
        $startDate = Carbon::parse($tenggat->tanggal_mulai . ' ' . $tenggat->jam_mulai);
        $endDate = Carbon::parse($tenggat->tanggal_selesai . ' ' . $tenggat->jam_selesai);

        return [
            'is_within_deadline' => $now->between($startDate, $endDate),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'formatted_start_date' => $startDate->format('d M Y H:i'),
            'formatted_end_date' => $endDate->format('d M Y H:i')
        ];
    }
}