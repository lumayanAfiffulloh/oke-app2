<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RencanaPembelajaran;
use App\Http\Requests\StoreRencanaPembelajaranRequest;
use App\Http\Requests\UpdateRencanaPembelajaranRequest;
use Illuminate\Support\Facades\Auth;

class RencanaPembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();
    
        // Ambil data pegawai terkait user
        $dataPegawai = $user->dataPegawai;
    
        // Ambil rencana pembelajaran yang terkait dengan pegawai
        $rencana_pembelajaran = $dataPegawai ? $dataPegawai->rencanaPembelajaran()->orderBy('tahun', 'asc')->paginate(10) : null;
    
        return view('rencana_pembelajaran_index', compact('rencana_pembelajaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('rencana_pembelajaran_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRencanaPembelajaranRequest $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['error' => 'Anda harus login terlebih dahulu untuk mengisi rencana pembelajaran.']);
        }

        // Validasi sudah dilakukan di StoreRencanaPembelajaranRequest
        $requestData = $request->validated();

        // Ambil data pegawai yang sedang login berdasarkan user_id
        $pegawai = \App\Models\DataPegawai::where('user_id', Auth::id())->first();

        // Jika pegawai tidak ditemukan, berikan pesan error
        if (!$pegawai) {
            return redirect()->back()->withErrors(['error' => 'Pegawai tidak ditemukan untuk user ini. Pastikan data pegawai sudah ada.']);
        }

        // Tambahkan data_pegawai_id ke dalam data yang akan disimpan
        $requestData['data_pegawai_id'] = $pegawai->id;

        // Simpan data ke dalam RencanaPembelajaran
        RencanaPembelajaran::create($requestData);

        // Flash message sukses
        flash('Yeay.. Data berhasil ditambah')->success();

        // Redirect ke halaman index
        return redirect()->route('rencana_pembelajaran.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(RencanaPembelajaran $rencanaPembelajaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RencanaPembelajaran $rencanaPembelajaran)
    {
        return view('rencana_pembelajaran_edit', compact('rencanaPembelajaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRencanaPembelajaranRequest $request, RencanaPembelajaran $rencanaPembelajaran)
    {
        $validatedData = $request->validated();
        $rencanaPembelajaran->update($validatedData);
        flash('Data berhasil diubah!')->success();
        return redirect()->route('rencana_pembelajaran.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RencanaPembelajaran $rencanaPembelajaran)
    {
        $rencanaPembelajaran->delete();
        flash('Data berhasil dihapus!')->error();
        return redirect()->route('rencana_pembelajaran.index');
    }
}
