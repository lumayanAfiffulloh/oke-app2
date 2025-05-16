<?php

namespace App\Http\Controllers;

use App\Models\BentukJalur;
use App\Http\Requests\StoreBentukJalurRequest;
use App\Http\Requests\UpdateBentukJalurRequest;
use Illuminate\Http\Request;

class BentukJalurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BentukJalur::query();

        $bentuk_jalur = $query->latest()->get();

        return view('bentuk_jalur_index', compact('bentuk_jalur'));

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
    public function store(StoreBentukJalurRequest $request)
    {
        // Validasi sudah dilakukan di StoreDataPelatihanRequest
        $requestData = $request->validated();

        // Simpan data ke dalam RencanaPembelajaran
        BentukJalur::create($requestData);

        // Flash message sukses
        flash('Bentuk jalur berhasil ditambah')->success();

        // Redirect ke halaman index
        return redirect()->route('bentuk_jalur.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBentukJalurRequest $request, BentukJalur $bentukJalur)
    {
        $validatedData = $request->validated();
        $bentukJalur->update($validatedData);
        flash('Bentuk jalur berhasil diubah!')->success();
        return redirect()->route('bentuk_jalur.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BentukJalur $bentukJalur)
    {
        $bentukJalur->delete();
        flash('Data berhasil dihapus!')->error();
        return redirect()->route('bentuk_jalur.index');
    }
}
