<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;
use App\Models\Jurusan;
use App\Models\DataPendidikan;
use App\Models\AnggaranPendidikan;
use App\Http\Requests\StoreDataPendidikanRequest;
use App\Http\Requests\UpdateDataPendidikanRequest;

class DataPendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua DataPendidikan dengan relasi 'jenjangs', dan 'jurusan'
        $dataPendidikan = DataPendidikan::with(['jenjangs', 'jurusan'])->latest()->get();
        $jenjang = Jenjang::whereIn('jenjang', ['S1', 'S2', 'S3'])->with('anggaranPendidikan')->get();


        return view('data_pendidikan_index', compact('dataPendidikan', 'jenjang'));
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

        // Cek dan buat data jurusan jika belum ada
        $jurusan = Jurusan::firstOrCreate([
            'jurusan' => $requestData['jurusan']
        ]);

        // Menyimpan data pendidikan ke tabel data_pendidikans
        $dataPendidikan = DataPendidikan::create([
            'jurusan_id' => $jurusan->id,
        ]);

        // Menyimpan relasi jenjang yang dipilih ke dalam pivot table
        if (!empty($requestData['jenjang'])) {
            foreach ($requestData['jenjang'] as $jenjang) {
                // Cek atau buat data jenjang jika belum ada
                $jenjangObj = Jenjang::firstOrCreate(['jenjang' => $jenjang]);

                // Menambahkan jenjang ke dataPendidikan (relasi many-to-many)
                $dataPendidikan->jenjangs()->attach($jenjangObj->id);
            }
        }
    
        // Flash message sukses
        flash('Data pendidikan berhasil ditambahkan')->success();
    
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
