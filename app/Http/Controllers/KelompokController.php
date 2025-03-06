<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelompok;
use App\Models\DataPegawai;
use App\Models\Role;
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
        $kelompok = Kelompok::latest()->get();
        $listPegawai = DataPegawai::where('kelompok_id', 0)->orderBy('nama', 'asc')->get();

        return view('kelompok_index', compact('kelompok', 'listPegawai'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listPegawai = DataPegawai::where('kelompok_id', 0)->orderBy('nama', 'asc')->get();
        return view('kelompok_create', compact('listPegawai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKelompokRequest $request)
    {
        $request->validated();
    
        $ketuaId = $request->id_ketua;
    
        // Buat kelompok baru
        $kelompok = Kelompok::create([
            'id_ketua' => $ketuaId,
        ]);
    
        // Update kelompok_id untuk ketua dan anggota
        DataPegawai::where('id', $ketuaId)->update(['kelompok_id' => $kelompok->id]);
        DataPegawai::whereIn('id', $request->anggota)->update(['kelompok_id' => $kelompok->id]);
    
        // Tambahkan role 'ketua_kelompok' ke user ketua
        $dataPegawai = DataPegawai::find($ketuaId);
        $user = User::find($dataPegawai->user_id);
    
        $roleKetua = Role::firstOrCreate(['role' => 'ketua_kelompok']);
        if ($user && !$user->roles->contains($roleKetua->id)) {
            $user->roles()->attach($roleKetua->id);
        }
    
        flash('Kelompok berhasil dibuat.')->success();
        return redirect()->route('kelompok.index');
    }

    public function edit(Kelompok $kelompok)
    {
        $listPegawai = DataPegawai::where(function ($query) use ($kelompok) {
            $query->where('kelompok_id', 0) // Pegawai yang belum memiliki kelompok
                ->orWhere('id', $kelompok->ketua_id)
                ->orWhere('kelompok_id', $kelompok->id);
            })->orderBy('nama', 'asc')->get();
        return view('kelompok_edit', compact('kelompok', 'listPegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKelompokRequest $request, Kelompok $kelompok)
    {
        $validatedData = $request->validated();

        if (in_array($validatedData['id_ketua'], $validatedData['anggota'])) {
            return back()->withErrors(['anggota' => 'Ketua kelompok tidak boleh dipilih sebagai anggota.']);
        }

        $kelompok->update(['id_ketua' => $validatedData['id_ketua']]);

        // Reset kelompok_id semua anggota lama
        DataPegawai::where('kelompok_id', $kelompok->id)->update(['kelompok_id' => null]);

        // Set kelompok_id untuk ketua dan anggota baru
        DataPegawai::where('id', $validatedData['id_ketua'])->update(['kelompok_id' => $kelompok->id]);
        DataPegawai::whereIn('id', $validatedData['anggota'])->update(['kelompok_id' => $kelompok->id]);

        // Tambahkan role 'ketua_kelompok' ke user ketua
        $user = User::find($validatedData['id_ketua']);
        if ($user) {
            $roleKetua = Role::where('role', 'ketua_kelompok')->first();
            if ($roleKetua && !$user->roles->contains($roleKetua->id)) {
                $user->roles()->attach($roleKetua->id);
            }
        }

        flash('Kelompok berhasil diperbarui.')->success();
        return redirect()->route('kelompok.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelompok = Kelompok::findOrFail($id);

        // Reset kelompok_id untuk semua anggota
        DataPegawai::where('kelompok_id', $kelompok->id)->update(['kelompok_id' => null]);

        // Hapus role 'ketua_kelompok' jika ada
        $ketuaUser = User::find($kelompok->id_ketua);
        $roleKetua = Role::where('role', 'ketua_kelompok')->first();
        if ($ketuaUser && $roleKetua) {
            $ketuaUser->roles()->detach($roleKetua->id);
        }

        $kelompok->delete();

        flash('Kelompok berhasil dihapus.')->error();
        return redirect()->route('kelompok.index');
    }

    public function reset()
    {
        $kelompok = Kelompok::all();

        foreach ($kelompok as $item) {
            DataPegawai::where('kelompok_id', $item->id)->update(['kelompok_id' => null]);

            $ketuaUser = User::find($item->id_ketua);
            $roleKetua = Role::where('role', 'ketua_kelompok')->first();
            if ($ketuaUser && $roleKetua) {
                $ketuaUser->roles()->detach($roleKetua->id);
            }
        }

        Kelompok::truncate();

        flash('Kelompok berhasil direset!')->error();
        return redirect()->route('kelompok.index');
    }
}