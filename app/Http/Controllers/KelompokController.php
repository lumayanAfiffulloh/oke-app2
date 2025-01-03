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

        $kelompok = $query->latest()->get();
        $listPegawai = DataPegawai::where('kelompok_id', 0)->orderBy('nama', 'asc')->get();

        return view('kelompok_index', compact('kelompok', 'listPegawai'));
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
            // Decode akses menjadi array jika berbentuk string, atau gunakan array kosong jika null
            $aksesArray = $user->akses ? explode(', ', $user->akses) : [];

            // Tambahkan "ketua_kelompok" jika belum ada
            if (!in_array('ketua_kelompok', $aksesArray)) {
                $aksesArray[] = 'ketua_kelompok';
            }

            // Pastikan "admin" tetap ada jika memang sudah ada
            if (str_contains($user->akses, 'admin') && !in_array('admin', $aksesArray)) {
                $aksesArray[] = 'admin';
            }

            // Simpan kembali sebagai string
            $user->update(['akses' => implode(', ', $aksesArray)]);
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
        // Cek apakah ketua sudah terdaftar sebagai anggota
        if (in_array($validatedData['ketua_id'], $validatedData['anggota'])) {
            return back()->withErrors(['anggota' => 'Ketua kelompok tidak boleh dipilih sebagai anggota.']);
        }

        // Update data kelompok
        $kelompok->update([
            'ketua_id' => $validatedData['ketua_id'],
        ]);

        // Update kelompok_id untuk ketua
        DataPegawai::where('id', $validatedData['ketua_id'])->update(['kelompok_id' => $kelompok->id]);

        // Set semua anggota yang sebelumnya ada di kelompok ini, kelompok_id mereka menjadi null
        DataPegawai::where('kelompok_id', $kelompok->id)->update(['kelompok_id' => null]);

        // Update anggota baru, tetapkan kelompok_id
        DataPegawai::whereIn('id', $validatedData['anggota'])->update(['kelompok_id' => $kelompok->id]);

        // Update akses ketua menjadi ketua_kelompok
        $user = User::where('id', $validatedData['ketua_id'])->first();
        if ($user) {
            $currentRoles = explode(',', $user->akses);

            if (!in_array('ketua_kelompok', $currentRoles)) {
                $currentRoles[] = 'ketua_kelompok';
            }

            $user->update(['akses' => implode(',', $currentRoles)]);
        }

        flash('Kelompok berhasil diperbarui.')->success();
        return redirect()->route('kelompok.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari kelompok berdasarkan ID
        $kelompok = Kelompok::findOrFail($id);

        // Ambil ID ketua kelompok
        $ketuaId = $kelompok->ketua_id;

        // Update kelompok_id dari semua anggota menjadi null
        DataPegawai::where('kelompok_id', $kelompok->id)->update(['kelompok_id' => null]);

        // Cek akses ketua, jika admin tetap admin, jika bukan admin kembalikan menjadi pegawai
        $user = User::where('id', $ketuaId)->first();
        if ($user) {
        if (str_contains($user->akses, 'admin')) {
            // Jika admin, hanya hapus ketua_kelompok
            $user->update(['akses' => 'admin']);
        } else {
            // Jika bukan admin, jadikan pegawai
            $user->update(['akses' => 'pegawai']);
        }
    }

        // Hapus kelompok
        $kelompok->delete();

        flash('Kelompok berhasi dihapus!')->error();
        return redirect()->route('kelompok.index');
    }

    public function reset()
    {
        // Ambil semua ketua kelompok sebelum reset
        $ketuaIds = Kelompok::pluck('ketua_id');

        // Update semua data_pegawais kelompok_id menjadi null
        DataPegawai::whereNotNull('kelompok_id')->update(['kelompok_id' => null]);

        Kelompok::truncate();

        // Perbarui akses ketua kelompok
        foreach ($ketuaIds as $ketuaId) {
            $user = User::where('id', $ketuaId)->first();
            if ($user) {
                if (str_contains($user->akses, 'admin')) {
                    // Jika admin, hanya hapus ketua_kelompok
                    $user->update(['akses' => 'admin']);
                } else {
                    // Jika bukan admin, jadikan pegawai
                    $user->update(['akses' => 'pegawai']);
                }
            }
        }

        // Redirect ke halaman daftar kelompok dengan pesan sukses
        flash('Kelompok berhasi direset!')->error();
        return redirect()->route('kelompok.index');
    }
}
