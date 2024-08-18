<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
        ]);
        $pegawai = new \App\Models\Pegawai;
        $pegawai->fill($requestData);
        if ($request->hasFile('foto')) {
            $pegawai->foto = $request->file('foto')->store('public');
        }
        $pegawai->save();
        flash('Yeay.. Data berhasil disimpan')->success();
        return redirect()->route('pegawai.index');
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
        $requestData = $request->validate([
            'nama' => 'nullable|min:3',
            'alamat' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'departemen' => 'nullable',
            'jabatan' => 'nullable',
            'pendidikan' => 'nullable',
            'role' => 'nullable',
            'jenis_kelamin' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
        ]);
        $pegawai = \App\Models\Pegawai::findOrfail($id);
        $pegawai->fill($requestData);
        if ($request->hasFile('foto')){
            Storage::delete($pegawai->foto);
            $pegawai->foto = $request->file('foto')->store('public');
        }
        $pegawai->save();
        flash('Yeay.. Data berhasil diubah')->success();
        return redirect()->route('pegawai.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pegawai = \App\Models\Pegawai::findOrfail($id);

        if ($pegawai->pelaksanaan_pembelajaran->count() >= 1){
            flash('Data pegawai tidak bisa dihapus karena sudah mendaftarkan pembelajaran')->error();
            return back();
        }

        if ($pegawai->foto != null && Storage::exists($pegawai->foto) ){
            Storage::delete($pegawai->foto);
        }
        $pegawai->delete();
        flash('Data berhasi dihapus')->success();
        return back();
    }
}
