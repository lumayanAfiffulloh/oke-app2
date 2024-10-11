<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelompok;
use App\Models\DataPegawai;
use App\Http\Requests\StoreKelompokRequest;
use App\Http\Requests\UpdateKelompokRequest;

class KelompokController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Kelompok::query();
        $kelompok['kelompok'] = $query->latest()->paginate(10);
        return view ('kelompok_index', $kelompok);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua pegawai yang belum menjadi ketua atau anggota kelompok
        $data['listPegawai'] = DataPegawai::where('kelompok_id', 0)->orderBy('nama', 'asc')->get();
        return view('kelompok_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKelompokRequest $request)
    {
        $request->validated();

        // Cek apakah ketua sudah memimpin kelompok
        $ketua = $request->ketua_id ;

        // Cek apakah ketua sudah terdaftar sebagai anggota
        if (in_array($ketua, $request->input('anggota'))) {
            return back()->withErrors(['anggota' => 'Ketua kelompok yang dpilih tidak boleh dipilih juga sebagai anggota.']);
        }

        // Membuat kelompok
        $kelompok = Kelompok::create([
            'ketua_id' => $request->ketua_id,
        ]);

        // Update kelompok_id untuk ketua
        DataPegawai::where('id', $ketua)->update(['kelompok_id' => $kelompok->id]);

        // Menambahkan anggota ke kelompok
        DataPegawai::whereIn('id', $request->anggota)->update(['kelompok_id' => $kelompok->id]);

        // Update akses ketua menjadi ketua_kelompok pada tabel users
        $user = User::where('id', $request->ketua_id)->first();
        if ($user) {
            // Jika role saat ini admin, tambahkan "ketua_kelompok" tanpa menghapus "admin"
            if (str_contains($user->akses, 'admin')) {
                $user->update(['akses' => 'admin, ketua_kelompok']);
            } else {
                $user->update(['akses' => 'ketua_kelompok']);
            }
        }

        flash('Kelompok berhasil dibuat.')->success();
        return redirect()->route('kelompok.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelompok $kelompok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelompok $kelompok)
    {
        $listPegawai = DataPegawai::orderBy('nama', 'asc')->get();
        return view('kelompok_edit', compact('kelompok', 'listPegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKelompokRequest $request, Kelompok $kelompok)
    {
        $validatedData = $request->validated();
        $kelompok->update($validatedData);
        flash('Data kelompok berhasil diubah!')->success();
        return redirect()->route('kelompok.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari kelompok berdasarkan ID
        $kelompok = Kelompok::findOrFail($id);

        // Update kelompok_id dari semua anggota menjadi null
        DataPegawai::where('kelompok_id', $kelompok->id)->update(['kelompok_id' => null]);

        // Hapus kelompok
        $kelompok->delete();

        flash('Kelompok berhasi dihapus!')->error();
        return redirect()->route('kelompok.index');
    }

    public function reset()
    {
        // Update semua data_pegawais kelompok_id menjadi null
        DataPegawai::whereNotNull('kelompok_id')->update(['kelompok_id' => null]);

        Kelompok::truncate();

        // Redirect ke halaman daftar kelompok dengan pesan sukses
        flash('Kelompok berhasi direset!')->error();
        return redirect()->route('kelompok.index');
    }
}
