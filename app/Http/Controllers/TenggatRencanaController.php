<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TenggatRencana;
use Illuminate\Support\Carbon;
use App\Models\KategoriTenggat;
use Illuminate\Validation\ValidationException;
use App\Notifications\TenggatRencanaNotification;

class TenggatRencanaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Controller
    public function index()
    {
        $kategoriTenggats = KategoriTenggat::with('tenggatRencana')->get();

        return view('tenggat_rencana_index', compact('kategoriTenggats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_tenggat_id' => 'required|exists:kategori_tenggats,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'jam_selesai' => 'required',
        ]);
    
        $tenggat = TenggatRencana::create($request->all());
    
        flash('Tenggat Rencana Berhasil Dibuat!')->success();
        return redirect()->back();
    }
    
    public function update(Request $request, TenggatRencana $tenggat_rencana)
    {
        // Validasi input
        $validatedData = $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'jam_selesai' => 'required',
        ]);
    
        // Cek apakah ada perubahan data
        if ($tenggat_rencana->fill($validatedData)->isDirty()) {
            // Update data
            $tenggat_rencana->save();
    
            // Set flash message sukses
            flash('Tenggat Rencana Berhasil Diperbarui!')->success();
            
        } else {
            // Set flash message tidak ada perubahan
            flash('Tidak ada perubahan data')->info();
        }
    
        // Redirect kembali ke halaman sebelumnya
        return redirect()->back();
    }
    
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
