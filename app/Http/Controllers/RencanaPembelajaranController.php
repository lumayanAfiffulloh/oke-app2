<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Rumpun;
use App\Models\Jenjang;
use App\Models\Jurusan;
use App\Models\Kategori;
use App\Models\BentukJalur;
use App\Models\DataPegawai;
use Illuminate\Http\Request;
use App\Models\DataPelatihan;
use App\Models\DataPendidikan;
use App\Models\JenisPendidikan;
use App\Models\AnggaranPelatihan;
use App\Models\AnggaranPendidikan;
use App\Models\RencanaPembelajaran;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreRencanaPembelajaranRequest;
use App\Http\Requests\UpdateRencanaPembelajaranRequest;

class RencanaPembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();
    
        // Ambil data pegawai terkait user
        $dataPegawai = $user->dataPegawai;
    
        // Ambil rencana pembelajaran yang terkait dengan pegawai
        $rencana_pembelajaran = $dataPegawai ? $dataPegawai->rencanaPembelajaran()->orderBy('tahun', 'asc')->get() : null;
    
        return view('rencana_pembelajaran_index', compact('rencana_pembelajaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rencana_pembelajaran = RencanaPembelajaran::get();
        $kategori = Kategori::get();
        $region = Region::all();

        return view ('rencana_pembelajaran_create', compact('rencana_pembelajaran', 'kategori', 'region'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRencanaPembelajaranRequest $request)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['error' => 'Anda harus login terlebih dahulu untuk mengisi rencana pembelajaran.']);
        }
    
        // Ambil data pegawai terkait user
        $pegawai = DataPegawai::where('user_id', Auth::id())->first();
        if (!$pegawai) {
            return redirect()->back()->withErrors(['error' => 'Data pegawai tidak ditemukan.']);
        }
    
        // Simpan rencana pembelajaran
        $validated = $request->validated();
    
        $rencana = new RencanaPembelajaran();
        $rencana->data_pegawai_id = $pegawai->id;
        $rencana->tahun = $validated['tahun'];
        $rencana->klasifikasi = $validated['klasifikasi'];
        $rencana->region_id = $validated['regional'];
        $rencana->anggaran_rencana = $validated['anggaran_rencana'];
        $rencana->prioritas = $validated['prioritas'];
    
        if ($validated['klasifikasi'] == 'pendidikan') {
            $dataPendidikan = DataPendidikan::where('id', $validated['jurusan'])
                ->whereHas('jenjangs', function ($query) use ($validated) {
                    $query->where('jenjangs.id', $validated['jenjang']); // Tentukan tabel yang ingin digunakan untuk kolom id
                })
                ->first();
        
            if ($dataPendidikan) {
                $rencana->data_pendidikan_id = $dataPendidikan->id;
                $rencana->jenis_pendidikan_id = $validated['jenis_pendidikan'];
            } else {
                // Jika data pendidikan tidak ditemukan, tambahkan pesan error
                return redirect()->back()->withErrors(['error' => 'Data pendidikan tidak ditemukan.']);
            }
        }
    
        $rencana->save();
    
        return redirect()->route('rencana_pembelajaran.index')->with('success', 'Rencana pembelajaran berhasil dibuat!');
    }
    

    
    


    /**
     * Display the specified resource.
     */
    public function show(RencanaPembelajaran $rencanaPembelajaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RencanaPembelajaran $rencanaPembelajaran)
    {
        return view('rencana_pembelajaran_edit', compact('rencanaPembelajaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRencanaPembelajaranRequest $request, RencanaPembelajaran $rencanaPembelajaran)
    {
        $validatedData = $request->validated();
        $rencanaPembelajaran->update($validatedData);
        flash('Data berhasil diubah!')->success();
        return redirect()->route('rencana_pembelajaran.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RencanaPembelajaran $rencanaPembelajaran)
    {
        $rencanaPembelajaran->delete();
        flash('Data berhasil dihapus!')->error();
        return redirect()->route('rencana_pembelajaran.index');
    }

    public function getBentukJalur($kategori_id)
    {
        // Ambil bentuk jalur yang sesuai dengan kategori_id
        $bentuk_jalur = BentukJalur::where('kategori_id', $kategori_id)->get();

        // Kembalikan bentuk jalur dalam format JSON
        return response()->json([
            'bentuk_jalur' => $bentuk_jalur
        ]);
    }

    public function getJenjang()
    {
        $jenjang = Jenjang::all(); // Ganti sesuai query data jenjang Anda
        return response()->json(['jenjang' => $jenjang]);
    }

    public function getJurusanByJenjang(Request $request)
    {
        // Cek jika ada parameter jenjang_id
        $jenjangId = $request->get('jenjang_id');
    
        // Ambil jurusan yang terkait dengan jenjang yang dipilih
        $dataPendidikans = DataPendidikan::whereHas('jenjangs', function ($query) use ($jenjangId) {
            $query->where('jenjang_id', $jenjangId);
        })->get();
    
        // Ambil jurusan dari data pendidikan yang ditemukan
        $jurusans = $dataPendidikans->map(function ($dataPendidikan) {
            return [
                'id' => $dataPendidikan->id,
                'jurusan' => $dataPendidikan->jurusan
            ];
        });
    
        return response()->json($jurusans);
    }

    public function getRumpun()
    {
        $rumpuns = Rumpun::all();
        return response()->json($rumpuns);
    } 

    public function getNamaPelatihan($rumpunId)
    {
        $pelatihan = DataPelatihan::where('rumpun_id', $rumpunId)->get();
        return response()->json($pelatihan);
    }

    public function getJenisPendidikan()
    {
        $jenisPendidikan = JenisPendidikan::all();
        return response()->json($jenisPendidikan);
    }

    public function getPelatihanInfo($id)
    {
        $pelatihan = DataPelatihan::find($id);

        if ($pelatihan) {
            return response()->json([
                'kode' => $pelatihan->kode,
                'nama_pelatihan' => $pelatihan->nama_pelatihan,
                'deskripsi' => $pelatihan->deskripsi,
            ]);
        } else {
            return response()->json([
                'error' => 'Pelatihan tidak ditemukan.'
            ], 404);
        }
    }

    public function getAnggaranByPendidikan(Request $request)
    {
        $jenjangId = $request->input('jenjang_id');

        // Ambil anggaran berdasarkan jenjang dan region
        $anggaranPendidikan = AnggaranPendidikan::with(['region'])
            ->where('jenjang_id', $jenjangId) // Filter berdasarkan jenjang_id
            ->get();

        // Menyediakan data anggaran dengan informasi region
        return response()->json($anggaranPendidikan);
    }


    public function getAnggaranByPelatihan(Request $request)
    {
        $pelatihanId = $request->pelatihan_id;

        // Ambil data anggaran berdasarkan pelatihan_id dengan relasi ke kategori dan region
        $anggaranPelatihan = AnggaranPelatihan::with(['kategori', 'region']) // Tambahkan 'region' ke dalam with()
            ->where('data_pelatihan_id', $pelatihanId)
            ->get();

        return response()->json($anggaranPelatihan);
    }




}
