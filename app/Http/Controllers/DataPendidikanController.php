<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;
use App\Models\Jurusan;
use App\Models\DataPendidikan;
use App\Models\EstimasiPendidikan;
use App\Http\Requests\StoreDataPendidikanRequest;
use App\Http\Requests\UpdateDataPendidikanRequest;

class DataPendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataPendidikan = DataPendidikan::latest()->get();

        return view('data_pendidikan_index', compact('dataPendidikan'));
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
    public function store(StoreDataPendidikanRequest $request)
    {
        $requestData = $request->validated();

        // Simpan data estimasi nasional
        $nasional = EstimasiPendidikan::create([
            'region' => 'nasional',
            'anggaran_min' => $requestData['nasional_min'],
            'anggaran_maks' => $requestData['nasional_maks'],
        ]);
    
        // Simpan data estimasi internasional
        $internasional = EstimasiPendidikan::create([
            'region' => 'internasional',
            'anggaran_min' => $requestData['internasional_min'],
            'anggaran_maks' => $requestData['internasional_maks'],
        ]);
    
        // Cek dan buat data jenjang jika belum ada
        $jenjang = Jenjang::firstOrCreate([
            'jenjang' => $requestData['jenjang']
        ]);

        // Cek dan buat data jurusan jika belum ada
        $jurusan = Jurusan::firstOrCreate([
            'jurusan' => $requestData['jurusan']
        ]);

        // Menyimpan data pendidikan ke tabel data_pendidikans
        $dataPendidikan = DataPendidikan::create([
            'jenjang_id' => $jenjang->id,
            'jurusan_id' => $jurusan->id,
        ]);
    
         // Simpan relasi di pivot table
        $dataPendidikan->estimasiPendidikans()->attach([$nasional->id, $internasional->id]);
    
        // Flash message sukses
        flash('Data pendidikan dan estimasi harga berhasil ditambahkan')->success();
    
        // Redirect ke halaman index
        return redirect()->route('data_pendidikan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataPendidikan $dataPendidikan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataPendidikan $dataPendidikan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDataPendidikanRequest $request, DataPendidikan $dataPendidikan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataPendidikan $dataPendidikan)
    {
        //
    }
}
