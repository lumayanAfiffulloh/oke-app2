<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\TenggatRencana;
use Symfony\Component\HttpFoundation\Response;

class CheckRencanaPembelajaranTime
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cari tenggat waktu yang relevan (sesuaikan dengan kategori_tenggat_id yang sesuai)
        $tenggat = TenggatRencana::where('kategori_tenggat_id', 'id_kategori_rencana_pembelajaran')->first();
        
        if (!$tenggat) {
            return response()->json(['message' => 'Tenggat waktu tidak ditemukan'], 403);
        }

        $now = now();
        $startDateTime = $tenggat->tanggal_mulai->setTimeFromTimeString($tenggat->jam_mulai);
        $endDateTime = $tenggat->tanggal_selesai->setTimeFromTimeString($tenggat->jam_selesai);

        if ($now < $startDateTime || $now > $endDateTime) {
            return response()->json(['message' => 'Operasi tidak diizinkan di luar tenggat waktu yang ditentukan'], 403);
        }

        return $next($request);
    }
}