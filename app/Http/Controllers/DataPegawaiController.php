<?php

namespace App\Http\Controllers;

use App;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
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
        $query = \App\Models\DataPegawai::query();

        if (request()->filled('q')) {
            $query->where('nama', 'like', '%' . request('q') . '%')->paginate(10);
        }elseif (request()->filled('w')) {
            $query->where('unit_kerja', 'like', '%' . request('w') . '%')->paginate(10);
        }elseif (request()->filled('e')) {
            $query->whereHas('user', function ($query) {
            $query->where('nip', 'like', '%' . request('e') . '%');});
        } 
            
        $data['data_pegawai'] = $query->latest()->paginate(10);

        // Cek jika tidak ada data yang ditemukan
        if ($data['data_pegawai']->isEmpty()) {
            // Setel pesan flash untuk tidak ada data ditemukan
            flash('Data yang Anda cari tidak ada.')->error();
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
            'nip' => 'required|integer|unique:data_pegawais,nip',
            'status' => 'required',
            'jabatan' => 'required',
            'unit_kerja' => 'required',
            'pendidikan' => 'required',
            'jenis_kelamin' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
            // Validasi untuk tabel users
            'email' => 'required|email|unique:users,email', // Email harus unik di tabel users
            'akses' => 'required|string', // Pastikan akses diisi dan berupa string
        ]);
        
        $user = User::create([
            'name' => $request->nama,
            'akses' => $requestData['akses'], // Username diisi dengan akses pegawai
            'email' => $requestData['email'], // Pastikan di form pegawai ada field email
            'password' => Hash::make('password'), // Default password
        ]);

        $data_pegawai = new \App\Models\DataPegawai;
        $data_pegawai->user_id = $user->id;

        // Hanya isi data yang relevan dari $requestData
        $data_pegawai->nama = $requestData['nama'];
        $data_pegawai->nip = $requestData['nip'];
        $data_pegawai->status = $requestData['status'];
        $data_pegawai->jabatan = $requestData['jabatan'];
        $data_pegawai->unit_kerja = $requestData['unit_kerja'];
        $data_pegawai->pendidikan = $requestData['pendidikan'];
        $data_pegawai->jenis_kelamin = $requestData['jenis_kelamin'];

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

        // Ambil data user yang terkait dengan data pegawai
        $data['user'] = $data['data_pegawai']->user;
    
        return view('pegawai_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Ambil data pegawai berdasarkan ID
        $data_pegawai = \App\Models\DataPegawai::findOrFail($id);

         // Ambil user terkait berdasarkan user_id
        $user = \App\Models\User::findOrFail($data_pegawai->user_id);

        // Validasi input
        $requestData = $request->validate([
            'nama' => 'nullable|min:3',
            'nip' => [
                'nullable',
                'integer',
                Rule::unique('data_pegawais', 'nip')->ignore($data_pegawai->id),
            ],
            'status' => 'nullable',
            'unit_kerja' => 'nullable',
            'jabatan' => 'nullable',
            'pendidikan' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
        ]);

        // Validasi input untuk tabel users
        $userData = $request->validate([
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'akses' => 'nullable|string',
        ]);

        $data_pegawai->fill($requestData);
        if ($request->hasFile('foto')){
            Storage::delete($data_pegawai->foto);
            $data_pegawai->foto = $request->file('foto')->store('public');
        }
        $data_pegawai->save();

        $user->fill($userData);
        $user->save();

        flash('Yeay.. Data berhasil diubah!')->success();
        return redirect()->route('data_pegawai.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $data_pegawai = \App\Models\DataPegawai::findOrfail($id);

        if ($data_pegawai->foto != null && Storage::exists($data_pegawai->foto) ){
            Storage::delete($data_pegawai->foto);
        }
        $data_pegawai->delete();
        flash('Data berhasi dihapus!')->error();
        return redirect()->route('data_pegawai.index');
    }
}
