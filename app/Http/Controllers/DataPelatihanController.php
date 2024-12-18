<?php

namespace App\Http\Controllers;

use App\Models\BentukJalur;
use App\Models\DataPelatihan;
use App\Http\Requests\StoreDataPelatihanRequest;
use App\Http\Requests\UpdateDataPelatihanRequest;

class DataPelatihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = DataPelatihan::query();
        $bentuk_jalur = BentukJalur::all();
        $data_pelatihan['data_pelatihan'] = $query->latest()->get();
        return view ('data_pelatihan_index', compact('bentuk_jalur'), $data_pelatihan);
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
    public function store(StoreDataPelatihanRequest $request)
    {
        // Validasi sudah dilakukan di StoreDataPelatihanRequest
        $requestData = $request->validated();

        // Simpan data ke dalam data pelatihan
        DataPelatihan::create($requestData);

        // Flash message sukses
        flash('Data pelatihan berhasil ditambah')->success();

        // Redirect ke halaman index
        return redirect()->route('data_pelatihan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataPelatihan $dataPelatihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataPelatihan $dataPelatihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDataPelatihanRequest $request, DataPelatihan $dataPelatihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataPelatihan $dataPelatihan)
    {
        $dataPelatihan->delete();
        flash('Data berhasil dihapus!')->error();
        return redirect()->route('data_pelatihan.index');
    }
}
