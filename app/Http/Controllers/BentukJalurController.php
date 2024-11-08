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

         // Filter kategori
        $kategori = $request->input('kategori');

        $query->when($kategori, function ($filter) use ($kategori) {
            return $filter->where('kategori', $kategori);
        });

        // Gunakan `get()` jika filter ada, dan `paginate(10)` jika tidak ada filter
        $bentuk_jalur = $kategori ? $query->get() : $query->latest()->paginate(10);

        return view ('bentuk_jalur_index', compact('bentuk_jalur', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bentuk_jalur_create');
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
     * Display the specified resource.
     */
    public function show(BentukJalur $bentukJalur)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BentukJalur $bentukJalur)
    {
        return view('bentuk_jalur_edit', compact('bentukJalur'));
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
        //
    }

    public function filterByKategori($kategori)
    {
        $bentukJalur = BentukJalur::where('kategori', $kategori)->get();
        return response()->json($bentukJalur);
    }
}
