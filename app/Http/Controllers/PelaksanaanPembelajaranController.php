<?php

namespace App\Http\Controllers;

use App\Models\PelaksanaanPembelajaran;
use App\Http\Requests\StorePelaksanaanPembelajaranRequest;
use App\Http\Requests\UpdatePelaksanaanPembelajaranRequest;

class PelaksanaanPembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['pelaksanaan_pembelajaran'] = \App\Models\PelaksanaanPembelajaran::latest()->paginate(10);
        return view ('pelaksanaan_pembelajaran_index', $data);
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
    public function store(StorePelaksanaanPembelajaranRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PelaksanaanPembelajaran $pelaksanaanPembelajaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PelaksanaanPembelajaran $pelaksanaanPembelajaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePelaksanaanPembelajaranRequest $request, PelaksanaanPembelajaran $pelaksanaanPembelajaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PelaksanaanPembelajaran $pelaksanaanPembelajaran)
    {
        //
    }
}
