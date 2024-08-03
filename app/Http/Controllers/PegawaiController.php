<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['pegawai'] = \App\Models\Pegawai::latest()->paginate(10);
        return view ('pegawai_index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ("pegawai_create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'nama' => 'required|min:3',
            'alamat' => 'required',
            'tanggal_lahir' => 'required|date',
            'departemen' => 'required',
            'jabatan' => 'required',
            'pendidikan' => 'required',
            'role' => 'required',
            'jenis_kelamin' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:10000',
        ]);
        $pegawai = new \App\Models\Pegawai;
        $pegawai->fill($requestData);
        $pegawai->foto = $request->file('foto')->store('public');
        $pegawai->save();
        flash('Yeay.. Data berhasil disimpan')->success();
        return back();

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['pegawai'] = \App\Models\Pegawai::findOrFail($id);
        return view('pegawai_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
