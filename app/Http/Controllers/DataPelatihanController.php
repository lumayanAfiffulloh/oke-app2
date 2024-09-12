<?php

namespace App\Http\Controllers;

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
        return view ('pelatihan_index');
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
        //
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
        //
    }
}
