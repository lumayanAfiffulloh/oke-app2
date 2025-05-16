<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\TenggatRencana;
use App\Models\KategoriTenggat;

class TanggalPerencanaanService
{
	public function getJadwalData()
	{
		$kategoriTenggat = KategoriTenggat::where('kategori_tenggat', 'perencanaan_pegawai')->first();
		$tenggatRencana = $kategoriTenggat ? TenggatRencana::where('kategori_tenggat_id', $kategoriTenggat->id)->first() : null;
		
		if (!$tenggatRencana) {
			return [
				'tenggatRencana' => null,
				'waktuMulai' => null,
				'waktuSelesai' => null,
				'isActive' => false,
				'sisaHari' => 0,
				'progressPercentage' => 0
			];
		}
		
		$waktuSekarang = Carbon::now();
		$waktuMulai = Carbon::parse($tenggatRencana->tanggal_mulai . ' ' . $tenggatRencana->jam_mulai);
		$waktuSelesai = Carbon::parse($tenggatRencana->tanggal_selesai . ' ' . $tenggatRencana->jam_selesai);
		
		return [
			'tenggatRencana' => $tenggatRencana,
			'waktuMulai' => $waktuMulai,
			'waktuSelesai' => $waktuSelesai,
			'sisaHari' => ceil($waktuSekarang->diffInDays($waktuSelesai, false)),
			'isActive' => $waktuSekarang->between($waktuMulai, $waktuSelesai),
			'progressPercentage' => $this->calculateProgress($waktuMulai, $waktuSelesai, $waktuSekarang)
		];
	}

	protected function calculateProgress($start, $end, $now)
	{
		if (!$now->between($start, $end)) {
			return 0;
		}
		
		$totalDuration = $start->diffInSeconds($end);
		$elapsedDuration = $now->diffInSeconds($start);
		return min(100, max(0, ($elapsedDuration / $totalDuration) * 100));
	}
}