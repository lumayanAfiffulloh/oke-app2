<?php

namespace App\Http\Controllers;

use App\Models\DataPegawai;
use App\Models\Kelompok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaKelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = DataPegawai::where('user_id', Auth::id())->first();

        // Inisialisasi variabel dengan nilai default
        $belumKelompok = (!$pegawai || $pegawai->kelompok_id == 0);
        $hasKelompok = !$belumKelompok;
        $isKetua = false;
        $ketuaKelompok = null;
        $kelompok = null; // Inisialisasi variabel kelompok

        if ($hasKelompok) {
            $kelompok = Kelompok::with('ketua')->find($pegawai->kelompok_id);
            $isKetua = ($kelompok && $kelompok->id_ketua == $pegawai->id);
            
            if (!$isKetua && $kelompok) {
                $ketuaKelompok = $kelompok->ketua;
            }
        }

        $dataPegawai = $hasKelompok && $kelompok
            ? DataPegawai::with('unitKerja')
                ->where('kelompok_id', $pegawai->kelompok_id)
                ->where('id', '!=', $kelompok->id_ketua)
                ->get()
            : collect();

        return view('anggota_kelompok_index', [
            'dataPegawai' => $dataPegawai,
            'belumKelompok' => $belumKelompok,
            'isKetua' => $isKetua,
            'hasKelompok' => $hasKelompok,
            'ketuaKelompok' => $ketuaKelompok,
            'kelompok' => $kelompok // Kirim variabel kelompok ke view
        ]);
    }

    public function updateWhatsAppLink(Request $request)
    {
        $request->validate([
            'whatsapp_link' => 'required|url|starts_with:https://chat.whatsapp.com/'
        ]);

        $kelompok = Kelompok::where('id_ketua', Auth::user()->dataPegawai->id)->firstOrFail();
        
        $kelompok->update([
            'link_grup_whatsapp' => $request->whatsapp_link,
        ]);

        flash('Link grup berhasil diperbarui!')->success();
        return back();
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
