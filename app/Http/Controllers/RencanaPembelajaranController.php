<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RencanaPembelajaran;
use App\Http\Requests\StoreRencanaPembelajaranRequest;
use App\Http\Requests\UpdateRencanaPembelajaranRequest;

class RencanaPembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['rencana_pembelajaran'] = \App\Models\RencanaPembelajaran::latest()->paginate(10);
        return view ('rencana_pembelajaran_index', $data);
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
        $requestData = $request->validated();  // Validasi sudah dilakukan di StoreRencanaPembelajaranRequest
        
        RencanaPembelajaran::create($requestData);
        
        flash('Yeay.. Data berhasil disimpan')->success();
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
