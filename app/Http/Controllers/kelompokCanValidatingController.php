<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use Illuminate\Http\Request;
use App\Services\DeadlineService;
use App\Models\RencanaPembelajaran;
use Illuminate\Support\Facades\Auth;
use App\Models\KelompokCanValidating;
use App\Models\CatatanValidasiKelompok;

class kelompokCanValidatingController extends Controller
{
    protected $deadlineService;

    public function __construct(DeadlineService $deadlineService)
    {
        $this->middleware('can:ketua_kelompok');
        $this->deadlineService = $deadlineService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil ketua kelompok (user yang sedang login)
        $ketuaKelompok = Auth::user()->dataPegawai;

        // Dapatkan informasi deadline
        $deadlineInfo = $this->deadlineService->getDeadlineInfo('validasi_kelompok');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;
    
        // Ambil kelompok yang dipimpin oleh ketua kelompok beserta anggota dan validasinya
        $kelompok = Kelompok::with(['anggota', 'kelompokCanValidating'])
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
            ->with(['dataPegawai', 'dataPelatihan', 'dataPendidikan', 'bentukJalur', 'region', 'jenjang', 'kelompokCanValidating.catatanValidasiKelompok'])
            ->get();
    
        // Mengelompokkan data berdasarkan status validasi
        $rencanaDisetujui = $rencana->filter(fn($item) => optional($item->kelompokCanValidating)->status === 'disetujui');
        $rencanaDirevisi = $rencana->filter(fn($item) => optional($item->kelompokCanValidating)->status === 'direvisi');
        $rencanaBelumDivalidasi = $rencana->filter(fn($item) => is_null(optional($item->kelompokCanValidating)->status));
    
        return view('validasi_kelompok_index', [
            'anggota' => $anggota,
            'rencanaDisetujui' => $rencanaDisetujui,
            'rencanaDirevisi' => $rencanaDirevisi,
            'rencanaBelumDivalidasi' => $rencanaBelumDivalidasi,
            'kelompok' => $kelompok,
            'isWithinDeadline' => $isWithinDeadline
        ]);
    }
    

    public function setujui(Request $request, $id)
    {
        $rencana = RencanaPembelajaran::findOrFail($id);
    
        // Cek tenggat waktu
        $deadlineInfo = $this->deadlineService->getDeadlineInfo('validasi_kelompok');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;
        
        if (!$isWithinDeadline) {
            flash('Tidak dapat menyetujui rencana pembelajaran di luar tenggat waktu yang ditentukan.')->error();
            return redirect()->route('validasi_kelompok.index');
        }

        // Ambil ketua kelompok yang sedang login
        $ketuaKelompok = Auth::user()->dataPegawai;
        
        // Ambil kelompok yang dipimpin oleh ketua
        $kelompok = Kelompok::where('id_ketua', $ketuaKelompok->id)->first();
    
        if (!$kelompok) {
            return redirect()->back()->with('error', 'Anda tidak memiliki kelompok.');
        }
    
        // Simpan validasi
        $validasi = KelompokCanValidating::create([
            'rencana_pembelajaran_id' => $rencana->id,
            'kelompok_id' => $kelompok->id,
            'status' => 'disetujui',
            'status_revisi' => 'disetujui',
        ]);
    
        // Simpan catatan validasi kelompok jika catatan tidak kosong
        if ($request->catatan) {
            CatatanValidasiKelompok::create([
                'kelompok_can_validating_id' => $validasi->id,
                'catatan' => $request->catatan,
            ]);
        }
    
        flash('Rencana berhasil disetujui.')->success();
        return redirect()->route('validasi_kelompok.index');
    }

    public function revisi(Request $request, $id)
    {
        $rencana = RencanaPembelajaran::findOrFail($id);
    
        // Cek tenggat waktu
        $deadlineInfo = $this->deadlineService->getDeadlineInfo('validasi_kelompok');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;
        
        if (!$isWithinDeadline) {
            flash('Tidak dapat merevisi rencana pembelajaran di luar tenggat waktu yang ditentukan.')->error();
            return redirect()->route('validasi_kelompok.index');
        }

        // Ambil ketua kelompok yang sedang login
        $ketuaKelompok = Auth::user()->dataPegawai;
        
        // Ambil kelompok yang dipimpin oleh ketua
        $kelompok = Kelompok::where('id_ketua', $ketuaKelompok->id)->first();
    
        if (!$kelompok) {
            return redirect()->back()->with('error', 'Anda tidak memiliki kelompok.');
        }
    
        // Simpan validasi
        $validasi = KelompokCanValidating::create([
            'rencana_pembelajaran_id' => $rencana->id,
            'kelompok_id' => $kelompok->id,
            'status' => 'direvisi',
            'status_revisi' => "belum_direvisi",
        ]);
    
        // Simpan catatan validasi kelompok
        CatatanValidasiKelompok::create([
            'kelompok_can_validating_id' => $validasi->id,
            'catatan' => $request->catatan,
        ]);
    
        flash('Revisi rencana berhasil dikirim ke pegawai.')->warning();
        return redirect()->route('validasi_kelompok.index');
    }

    public function setujuiDariRevisi(Request $request, $id)
    {
        // Cari data validasi berdasarkan ID rencana
        $validasi = KelompokCanValidating::where('rencana_pembelajaran_id', $id)->first();
    
        // Cek tenggat waktu
        $deadlineInfo = $this->deadlineService->getDeadlineInfo('validasi_kelompok');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;
        
        if (!$isWithinDeadline) {
            flash('Tidak dapat menyetujui rencana pembelajaran di luar tenggat waktu yang ditentukan.')->error();
            return redirect()->route('validasi_kelompok.index');
        }

        if (!$validasi) {
            flash('Data validasi tidak ditemukan.')->error();
            return redirect()->back();
        }
    
        // Cek apakah status_revisi sudah "sudah_direvisi"
        if ($validasi->status_revisi !== 'sudah_direvisi') {
            flash('Revisi belum selesai, silakan minta revisi kepada pegawai terkait!')->error();
            return redirect()->back();
        }
    
        // Update status menjadi "disetujui" dan hapus status revisi
        $validasi->update([
            'status' => 'disetujui',
            'status_revisi' => null,
        ]);
    
        // Hapus catatan validasi sebelumnya
        CatatanValidasiKelompok::where('kelompok_can_validating_id', $validasi->id)->delete();
    
        // Jika pengguna memasukkan catatan baru, simpan catatan tersebut
        if ($request->filled('catatan')) {
            CatatanValidasiKelompok::create([
                'kelompok_can_validating_id' => $validasi->id,
                'catatan' => $request->catatan,
            ]);
        }
    
        flash('Rencana berhasil disetujui.')->success();
        return redirect()->route('validasi_kelompok.index');
    }    
    

    public function tambahRevisi(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'catatan' => 'required|string', // Pastikan catatan tidak kosong
        ]);
    
        // Cari rencana pembelajaran berdasarkan ID
        $rencana = RencanaPembelajaran::findOrFail($id);

        // Cek tenggat waktu
        $deadlineInfo = $this->deadlineService->getDeadlineInfo('validasi_kelompok');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;
        
        if (!$isWithinDeadline) {
            flash('Tidak dapat menambah revisi rencana pembelajaran di luar tenggat waktu yang ditentukan.')->error();
            return redirect()->route('validasi_kelompok.index');
        }
    
        // Ambil ketua kelompok yang sedang login
        $ketuaKelompok = Auth::user()->dataPegawai;
    
        // Ambil kelompok yang dipimpin oleh ketua
        $kelompok = Kelompok::where('id_ketua', $ketuaKelompok->id)->first();
    
        if (!$kelompok) {
            return redirect()->back()->with('error', 'Anda tidak memiliki kelompok.');
        }
    
        // Cari verifikasi terakhir untuk rencana pembelajaran ini
        $verifikasiTerakhir = KelompokCanValidating::where('rencana_pembelajaran_id', $rencana->id)
            ->where('kelompok_id', $kelompok->id)
            ->latest() // Ambil verifikasi terbaru
            ->first();
    
        // Jika verifikasi terakhir tidak ditemukan, kembalikan error
        if (!$verifikasiTerakhir) {
            return redirect()->back()->with('error', 'Verifikasi tidak ditemukan.');
        }
    
        // Update status verifikasi menjadi "direvisi"
        $verifikasiTerakhir->update([
            'status' => 'direvisi',
            'status_revisi' => 'belum_direvisi', // Set status revisi ke "belum_direvisi"
        ]);
    
        // Tambahkan catatan revisi baru ke tabel CatatanVerifikasiKelompok
        CatatanValidasiKelompok::create([
            'kelompok_can_validating_id' => $verifikasiTerakhir->id,
            'catatan' => $request->catatan,
        ]);
    
        // Beri feedback ke user
        flash('Revisi berhasil ditambahkan.')->warning();
        return redirect()->route('validasi_kelompok.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validasi = KelompokCanValidating::find($id);
        
        // Cek tenggat waktu
        $deadlineInfo = $this->deadlineService->getDeadlineInfo('validasi_kelompok');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;
        
        if (!$isWithinDeadline) {
            flash('Tidak dapat mengedit validasi rencana pembelajaran di luar tenggat waktu yang ditentukan.')->error();
            return redirect()->route('validasi_kelompok.index');
        }

        $catatan = CatatanValidasiKelompok::where('kelompok_can_validating_id', $validasi->id);
        if ($validasi) {
            $validasi->delete();
            $catatan->delete();
            if ($validasi->status == 'disetujui') {
                flash('Persetujuan Rencana Dibatalkan!')->error(); // warna merah
            } elseif ($validasi->status == 'ditolak') {
                flash('Penolakan Rencana Dibatalkan!')->success(); // warna hijau
            }
        } else {
            flash('Data Rencana Tidak Ditemukan!')->error(); // warna merah
        }
        return redirect()->route('validasi_kelompok.index');
    }
}
