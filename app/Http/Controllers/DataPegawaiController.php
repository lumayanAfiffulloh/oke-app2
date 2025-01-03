<?php

namespace App\Http\Controllers;

use App;
use Excel;
use App\Models\User;
use App\Models\DataPegawai;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Imports\DataPegawaiImport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Validators\ValidationException;

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
        $query = DataPegawai::query();
        
        $data['data_pegawai'] = $query->latest()->get();

        return view('pegawai_index', $data);
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
            'nppu' => 'required|unique:data_pegawais,nppu',
            'status' => 'required',
            'jabatan' => 'required',
            'unit_kerja' => 'required',
            'pendidikan' => 'required',
            'jurusan_pendidikan' => 'required',
            'jenis_kelamin' => 'required',
            'nomor_telepon' => 'nullable|integer',
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
        $data_pegawai->nppu = $requestData['nppu'];
        $data_pegawai->status = $requestData['status'];
        $data_pegawai->jabatan = $requestData['jabatan'];
        $data_pegawai->unit_kerja = $requestData['unit_kerja'];
        $data_pegawai->pendidikan = $requestData['pendidikan'];
        $data_pegawai->jurusan_pendidikan = $requestData['jurusan_pendidikan'];
        $data_pegawai->jenis_kelamin = $requestData['jenis_kelamin'];
        $data_pegawai->nomor_telepon = $request->has('nomor_telepon') ? $requestData['nomor_telepon'] : null;

        if ($request->hasFile('foto')) {
            $data_pegawai->foto = $request->file('foto')->store('public');
        }
        $data_pegawai->save();
        flash('Data berhasil disimpan!')->success();
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
        $data_pegawai = DataPegawai::findOrFail($id);

         // Ambil user terkait berdasarkan user_id
        $user = User::findOrFail($data_pegawai->user_id);

        // Validasi input
        $requestData = $request->validate([
            'nama' => 'nullable|min:3',
            'nppu' => [
                'nullable', Rule::unique('data_pegawais', 'nppu')->ignore($data_pegawai->id),
            ],
            'status' => 'nullable',
            'unit_kerja' => 'nullable',
            'jabatan' => 'nullable',
            'pendidikan' => 'nullable',
            'jurusan_pendidikan' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'nomor_telepom' => 'nullable',
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

        flash('Data berhasil diubah!')->success();
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

        $user = $data_pegawai->user;

        $data_pegawai->delete();

        if ($user) {
            $user->delete(); 
        }

        flash('Data berhasi dihapus!')->error();
        return redirect()->route('data_pegawai.index');
    }

    public function importExcelData(Request $request)
    {
        $request->validate([
            'importDataPegawai' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv' // Validasi tipe file
            ],
        ], [
            'importDataPegawai.required' => 'File impor wajib diunggah.',
            'importDataPegawai.file' => 'Berkas harus berupa file.',
            'importDataPegawai.mimes' => 'Format file harus berupa xlsx, xls, atau csv.',
        ]);

        try {
            Excel::import(new DataPegawaiImport, $request->file('importDataPegawai'));
            flash('Data berhasil diimport!')->success();
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorMessage = "Gagal mengimpor data. Periksa file Anda.";
            
            foreach ($failures as $failure) {
                $errorMessage .= " Baris: {$failure->row()}, Kolom: " . implode(', ', $failure->attribute());
            }
            flash($errorMessage)->error();
        } catch (\Exception $e) {
            flash('Import File Gagal. Pastikan format file sesuai dengan template!')->error();
        }

        return redirect()->route('data_pegawai.index');
    }

}
