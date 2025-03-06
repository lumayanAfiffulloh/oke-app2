<?php

namespace App\Http\Controllers;

use App\Models\DataPegawai;
use App\Models\Kelompok;
use App\Models\kelompokCanVerifying;
use App\Models\RencanaPembelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiKelompokController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:ketua_kelompok');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil ketua kelompok (user yang sedang login)
        $ketuaKelompok = Auth::user()->dataPegawai;
    
        // Ambil kelompok yang dipimpin oleh ketua kelompok beserta anggota dan verifikasinya
        $kelompok = Kelompok::with(['anggota', 'verifikasiKelompok'])
            ->where('id_ketua', $ketuaKelompok->id)
            ->first();
    
        if (!$kelompok) {
            flash('Anda tidak memiliki kelompok.')->error();
            return redirect()->back();
        }
    
        // Ambil semua anggota kelompok
        $anggota = $kelompok->anggota;
    
        // Ambil semua rencana pembelajaran milik anggota kelompok yang statusnya "diajukan"
        $rencana = RencanaPembelajaran::whereIn('data_pegawai_id', $anggota->pluck('id'))
            ->where('status_pengajuan', 'diajukan') // Tambahkan filter status_pengajuan
            ->with(['dataPegawai', 'dataPelatihan', 'dataPendidikan', 'bentukJalur', 'region', 'jenjang', 'verifikasiKelompok'])
            ->get();
    
        // Mengelompokkan data berdasarkan status verifikasi
        $rencanaDisetujui = $rencana->filter(fn($item) => optional($item->verifikasiKelompok)->status === 'disetujui');
        $rencanaDitolak = $rencana->filter(fn($item) => optional($item->verifikasiKelompok)->status === 'ditolak');
        $rencanaBelumDiverifikasi = $rencana->filter(fn($item) => is_null(optional($item->verifikasiKelompok)->status));
    
        // Ambil catatan dari verifikasi
        $catatan = $kelompok->verifikasiKelompok->pluck('catatan', 'rencana_pembelajaran_id');
    
        return view('verifikasi_kelompok_index', [
            'anggota' => $anggota,
            'rencanaDisetujui' => $rencanaDisetujui,
            'rencanaDitolak' => $rencanaDitolak,
            'rencanaBelumDiverifikasi' => $rencanaBelumDiverifikasi,
            'kelompok' => $kelompok,
            'catatan' => $catatan,
        ]);
    }
    

    public function setujui(Request $request)
    {
        $request->validate([
            'rencana_pembelajaran_id' => 'required|exists:rencana_pembelajarans,id',
            'kelompok_id' => 'required|exists:kelompoks,id',
            'catatan' => 'nullable|string',
        ]);

        $rencana = RencanaPembelajaran::findOrFail($request->rencana_pembelajaran_id);

        if ($rencana->status_pengajuan !== 'diajukan') {
            flash('Data Rencana Belum Diajukan untuk Verifikasi!')->success();
            return redirect()->back();
        }

        $verifikasiKelompok = $rencana->verifikasiKelompok;

        if ($verifikasiKelompok->status == 'ditolak') {
            if ($verifikasiKelompok->status_revisi != 'sudah_direvisi') {
                flash('Revisi belum selesai, silakan minta revisi kepada pegawai terkait!')->error();
                return redirect()->back();
            }
            // Ubah status menjadi disetujui
            $verifikasiKelompok->status = 'disetujui';
            // Hapus catatan lama
            $verifikasiKelompok->catatan = null;
            // Tambahkan catatan baru
            $verifikasiKelompok->catatan = $request->catatan ?? '';
            // Hilangkan status revisi
            $verifikasiKelompok->status_revisi = null;
            $verifikasiKelompok->save();
        } else {
            // Buat baru jika belum ada
            KelompokCanVerifying::create([
                'kelompok_id' => $request->kelompok_id,
                'rencana_pembelajaran_id' => $request->rencana_pembelajaran_id,
                'status' => 'disetujui',
                'catatan' => $request->catatan ?? '',
            ]);
        }

        flash('Data Rencana Berhasil Disetujui!')->success();
        return redirect()->route('verifikasi_kelompok.index');
    }

    public function tolak(Request $request)
    {
        $request->validate([
            'rencana_pembelajaran_id' => 'required|exists:rencana_pembelajarans,id',
            'kelompok_id' => 'required|exists:kelompoks,id',
            'catatan' => 'required|string',
        ]);

        $rencana = RencanaPembelajaran::findOrFail($request->rencana_pembelajaran_id);

        if ($rencana->status_pengajuan !== 'diajukan') {
            flash('Data Rencana Belum Diajukan untuk Verifikasi!')->success();
            return redirect()->back();
        }

        KelompokCanVerifying::create([
            'kelompok_id' => $request->kelompok_id,
            'rencana_pembelajaran_id' => $request->rencana_pembelajaran_id,
            'status' => 'ditolak',
            'catatan' => $request->catatan,
            'status_revisi' => 'belum_direvisi',
        ]);

        flash('Data Rencana Berhasil Ditolak!')->error();
        return redirect()->route('verifikasi_kelompok.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
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
    public function destroy($id)
    {
        $verifikasi = KelompokCanVerifying::find($id);
        if ($verifikasi) {
            $verifikasi->delete();
            if ($verifikasi->status == 'disetujui') {
                flash('Persetujuan Rencana Dibatalkan!')->error(); // warna merah
            } elseif ($verifikasi->status == 'ditolak') {
                flash('Penolakan Rencana Dibatalkan!')->success(); // warna hijau
            }
        } else {
            flash('Data Rencana Tidak Ditemukan!')->error(); // warna merah
        }
        return redirect()->route('verifikasi_kelompok.index');
    }
}
