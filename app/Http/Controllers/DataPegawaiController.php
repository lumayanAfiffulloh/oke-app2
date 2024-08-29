<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('can:admin');
    }

    public function index()
    {
        
        if (request()->filled('q')) {
            $data['data_pegawai'] = \App\Models\DataPegawai::where('nama', 'like', '%' . request('q') . '%')->paginate(10);
        }elseif (request()->filled('w')) {
            $data['data_pegawai'] = \App\Models\DataPegawai::where('unit_kerja', 'like', '%' . request('w') . '%')->paginate(10);
        }elseif (request()->filled('e')) {
            $data['data_pegawai'] = \App\Models\DataPegawai::where('nip', 'like', '%' . request('e') . '%')->paginate(10);
        } else {
            $data['data_pegawai'] = \App\Models\DataPegawai::latest()->paginate(10);
        }
        return view ('pegawai_index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view ('pegawai_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $requestData = $request->validate([
            'nama' => 'required|min:3',
            'status' => 'required',
            'tanggal_lahir' => 'required|date',
            'unit_kerja' => 'required',
            'jabatan' => 'required',
            'pendidikan' => 'required',
            'role' => 'required',
            'jenis_kelamin' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
        ]);
        $data_pegawai = new \App\Models\DataPegawai;
        $data_pegawai->fill($requestData);
        if ($request->hasFile('foto')) {
            $data_pegawai->foto = $request->file('foto')->store('public');
        }
        $data_pegawai->save();
        flash('Yeay.. Data berhasil disimpan!')->success();
        return redirect()->route('data_pegawai.index');
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
        
        $data['data_pegawai'] = \App\Models\DataPegawai::findOrFail($id);
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
            'unit_kerja' => 'nullable',
            'jabatan' => 'nullable',
            'pendidikan' => 'nullable',
            'role' => 'nullable',
            'jenis_kelamin' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
        ]);
        $data_pegawai = \App\Models\DataPegawai::findOrfail($id);
        $data_pegawai->fill($requestData);
        if ($request->hasFile('foto')){
            Storage::delete($data_pegawai->foto);
            $data_pegawai->foto = $request->file('foto')->store('public');
        }
        $data_pegawai->save();
        flash('Yeay.. Data berhasil diubah!')->success();
        return redirect()->route('data_pegawai.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $data_pegawai = \App\Models\DataPegawai::findOrfail($id);

        // if ($data_pegawai->pelaksanaan_pembelajaran->count() >= 1){
        //     flash('Data data_pegawai tidak bisa dihapus karena sudah mendaftarkan pembelajaran')->error();
        //     return back();
        // }

        if ($data_pegawai->foto != null && Storage::exists($data_pegawai->foto) ){
            Storage::delete($data_pegawai->foto);
        }
        $data_pegawai->delete();
        flash('Data berhasi dihapus!')->error();
        return redirect()->route('data_pegawai.index');
    }
}
