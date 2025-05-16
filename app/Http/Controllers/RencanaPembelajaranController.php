<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Rumpun;
use App\Models\Jenjang;
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
use App\Services\DeadlineService;
use Illuminate\Support\Facades\DB;

class RencanaPembelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $deadlineService;

    public function __construct(DeadlineService $deadlineService)
    {
        $this->deadlineService = $deadlineService;
    }


    public function index(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->dataPegawai) {
            return redirect()->back()->with('error', 'Anda tidak memiliki data pegawai.');
        }
    
        // Dapatkan informasi deadline
        $deadlineInfo = $this->deadlineService->getDeadlineInfo('perencanaan_pegawai');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;
        $startDate = $deadlineInfo['start_date'] ?? null;
        $endDate = $deadlineInfo['end_date'] ?? null;
        
        $dataPegawai = $user->dataPegawai;
        $rencana_pembelajaran = $dataPegawai->rencanaPembelajaran()->with(['bentukJalur', 'jenisPendidikan', 'region', 'dataPelatihan', 'dataPendidikan', 'kelompokCanValidating'])->latest()->get();
    
        $notifikasi = [
            'disetujui' => $rencana_pembelajaran->where('kelompokCanValidating.status', 'disetujui')->count(),
            'direvisi' => $rencana_pembelajaran->where('kelompokCanValidating.status_revisi', 'belum_direvisi')->count(),
        ];
        
        return view('rencana_pembelajaran_index', compact('rencana_pembelajaran', 'notifikasi', 'isWithinDeadline', 'startDate', 'endDate'));
    }
    
    public function ajukanVerifikasi($id)
    {
        $rencana = RencanaPembelajaran::findOrFail($id);

        if ($rencana->status_pengajuan === 'draft') {
            $rencana->update(['status_pengajuan' => 'diajukan']);
            flash('Rencana Pembelajaran berhasil diajukan untuk divalidasi!')->success();
            return redirect()->route('rencana_pembelajaran.index');
        }

        return redirect()->back()->with('error', 'Rencana tidak bisa diajukan.');
    }

    public function kirimRevisi($id)
    {
        $rencana = RencanaPembelajaran::find($id);

        // Periksa apakah status revisi saat ini adalah sedang_direvisi
        if ($rencana->kelompokCanValidating->status_revisi == 'sedang_direvisi') {
            // Ubah status revisi menjadi sudah_direvisi
            $rencana->kelompokCanValidating->status_revisi = 'sudah_direvisi';
            $rencana->kelompokCanValidating->save();

            flash('Revisi berhasil dikirim')->success();
        } else {
            flash('Revisi belum dilakukan, silakan revisi rencana pembelajaran terlebih dahulu')->error();
        }

        return redirect()->back();
    }



    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rencana_pembelajaran = RencanaPembelajaran::get();
        $kategori = Kategori::get();
        $region = Region::all();
        // Cek tenggat waktu
        $deadlineInfo = $this->deadlineService->getDeadlineInfo('perencanaan_pegawai');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;
        
        if (!$isWithinDeadline) {
            flash('Tidak dapat menambahkan rencana pembelajaran di luar tenggat waktu yang ditentukan.')->error();
            return redirect()->route('rencana_pembelajaran.index');
        }

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

        // Cek tenggat waktu
        $deadlineInfo = $this->deadlineService->getDeadlineInfo('perencanaan_pegawai');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;
        
        if (!$isWithinDeadline) {
            flash('Tidak dapat menambahkan rencana pembelajaran di luar tenggat waktu yang ditentukan.')->error();
            return redirect()->route('rencana_pembelajaran.index');
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
        $rencana->jam_pelajaran = $validated['jam_pelajaran'];
        $rencana->klasifikasi = $validated['klasifikasi'];
        $rencana->region_id = $validated['regional'];
        $rencana->anggaran_rencana = $validated['anggaran_rencana'];
        $rencana->prioritas = $validated['prioritas'];
        
        // Cek klasifikasi dan simpan data yang relevan
        if ($validated['klasifikasi'] == 'pendidikan') {
            // Tangani klasifikasi 'pendidikan'
            $rencana->jenjang_id = $validated['jenjang'];
            $dataPendidikan = DataPendidikan::where('id', $validated['jurusan'])
                ->whereHas('jenjangs', function ($query) use ($validated) {
                    $query->where('jenjangs.id', $validated['jenjang']);
                })
                ->first();
    
            if ($dataPendidikan) {
                $rencana->data_pendidikan_id = $dataPendidikan->id;
                $rencana->jenis_pendidikan_id = $validated['jenis_pendidikan'];
            } else {
                return redirect()->back()->withErrors(['error' => 'Data pendidikan tidak ditemukan.']);
            }
        } elseif ($validated['klasifikasi'] == 'pelatihan') {
            // Tangani klasifikasi 'pelatihan'
            $dataPelatihan = DataPelatihan::find($validated['nama_pelatihan']);
            if ($dataPelatihan) {
                $rencana->data_pelatihan_id = $dataPelatihan->id;
                $rencana->bentuk_jalur_id = $validated['bentuk_jalur'];  // Pastikan 'bentuk_jalur' ada dalam request
            } else {
                return redirect()->back()->withErrors(['error' => 'Data pelatihan tidak ditemukan.']);
            }
        }
    
        $rencana->save();
    
        flash('Rencana Pembelajaran berhasil dibuat!')->success();
        return redirect()->route('rencana_pembelajaran.index');
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
        // Cek tenggat waktu
        $deadlineInfo = $this->deadlineService->getDeadlineInfo('perencanaan_pegawai');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;
        
        if (!$isWithinDeadline) {
            flash('Tidak dapat menambahkan rencana pembelajaran di luar tenggat waktu yang ditentukan.')->error();
            return redirect()->route('rencana_pembelajaran.index');
        }

        if ($rencanaPembelajaran->kelompokCanValidating && $rencanaPembelajaran->kelompokCanValidating->status == 'disetujui') {
            flash('Rencana pembelajaran ini telah disetujui dan tidak dapat diedit.')->error();
            return redirect()->back();
        }
        if ($rencanaPembelajaran->kelompokCanValidating && $rencanaPembelajaran->kelompokCanValidating->status_revisi == 'sudah_direvisi') {
            flash('Revisi sudah selesai dan tidak dapat diubah lagi')->error();
            return redirect()->back();
        }
        $rencana = RencanaPembelajaran::findOrFail($rencanaPembelajaran->id);
        $kategori = Kategori::get();
        $region = Region::all();
        $bentukJalur = BentukJalur::where('kategori_id', $rencana->bentukJalur->kategori_id)->get();
    
        // Ambil rumpun yang sebelumnya dipilih berdasarkan data_pelatihan_id
        $rumpunTerpilih = $rencana->data_pelatihan_id 
            ? DataPelatihan::where('id', $rencana->data_pelatihan_id)->value('rumpun_id') 
            : null;
    
        // Ambil semua rumpun untuk dropdown
        $rumpun = Rumpun::all();
    
        // Ambil daftar nama pelatihan berdasarkan rumpun yang sebelumnya dipilih
        $pelatihan = $rumpunTerpilih 
            ? DataPelatihan::where('rumpun_id', $rumpunTerpilih)->get() 
            : collect(); // Jika belum ada rumpun, kosongkan
    
        // Nama Pelatihan yang sebelumnya dipilih
        $pelatihanTerpilih = DataPelatihan::find($rencana->data_pelatihan_id);
    
        // Ambil anggaran untuk pelatihan yang dipilih
        $anggaran = $pelatihanTerpilih 
            ? AnggaranPelatihan::where('data_pelatihan_id', $pelatihanTerpilih->id)
                ->with('region', 'kategori') // Memuat relasi region dan kategori
                ->get()
            : collect(); // Jika tidak ada pelatihan terpilih, kosongkan anggaran
    
        // Kelompokkan anggaran berdasarkan region
        $anggaranGrouped = $anggaran->groupBy(function ($item) {
            return $item->region->region; // Kelompokkan berdasarkan nama region
        });

        // Ambil anggaran pendidikan (jika rencana bukan pelatihan)
        $anggaranPendidikan = $rencana->klasifikasi == 'pendidikan' 
            ? AnggaranPendidikan::where('jenjang_id', $rencana->jenjang_id)
                ->with('region') // Memuat relasi region
                ->get()
            : collect();
    
        // Ambil semua jenjang
        $jenjang = Jenjang::all();
        $jenjangTerpilih = $rencana->jenjang_id;
    
        // Ambil semua jurusan
        $jurusan = DataPendidikan::all();
        $jurusanTerpilih = $rencana->data_pendidikan_id;
    
        // Ambil jenis pendidikan dari entitasnya (asumsi: ada model JenisPendidikan)
        $jenisPendidikan = JenisPendidikan::all();
        $jenisPendidikanTerpilih = $rencana->jenis_pendidikan_id;
    
        return view('rencana_pembelajaran_edit', compact(
            'rencana', 'kategori', 'region', 'bentukJalur', 'rumpun', 'rumpunTerpilih', 'pelatihan', 'pelatihanTerpilih', 'anggaranGrouped', 'jenjang', 'jenjangTerpilih', 'jurusan', 'jurusanTerpilih', 'jenisPendidikan', 'jenisPendidikanTerpilih', 'anggaranPendidikan'
        ));
    }
    
    
    


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRencanaPembelajaranRequest $request, $id)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['error' => 'Anda harus login terlebih dahulu untuk mengupdate rencana pembelajaran.']);
        }

        // Cek tenggat waktu
        $deadlineInfo = $this->deadlineService->getDeadlineInfo('perencanaan_pegawai');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;
        
        if (!$isWithinDeadline) {
            flash('Tidak dapat menambahkan rencana pembelajaran di luar tenggat waktu yang ditentukan.')->error();
            return redirect()->route('rencana_pembelajaran.index');
        }
    
        // Ambil data rencana pembelajaran yang akan diupdate
        $rencana = RencanaPembelajaran::find($id);
    
        // Pastikan rencana pembelajaran ditemukan
        if (!$rencana) {
            return redirect()->back()->withErrors(['error' => 'Rencana pembelajaran tidak ditemukan.']);
        }
    
        // Ambil data pegawai terkait user
        $pegawai = DataPegawai::where('user_id', Auth::id())->first();
        if (!$pegawai) {
            return redirect()->back()->withErrors(['error' => 'Data pegawai tidak ditemukan.']);
        }
    
        // Pastikan rencana pembelajaran milik pegawai
        if ($rencana->data_pegawai_id != $pegawai->id) {
            return redirect()->back()->withErrors(['error' => 'Anda tidak memiliki hak akses untuk mengupdate rencana pembelajaran ini.']);
        }
    
        // Simpan data lama sebelum diupdate
        $oldData = $rencana->getAttributes();
    
        // Update rencana pembelajaran
        $validated = $request->validated();
    
        $rencana->tahun = $validated['tahun'];
        $rencana->jam_pelajaran = $validated['jam_pelajaran'];
        $rencana->klasifikasi = $validated['klasifikasi'];
        $rencana->region_id = $validated['regional'];
        $rencana->anggaran_rencana = $validated['anggaran_rencana'];
        $rencana->prioritas = $validated['prioritas'];
    
        // Cek klasifikasi dan update data yang relevan
        if ($validated['klasifikasi'] == 'pendidikan') {
            // Tangani klasifikasi 'pendidikan'
            $rencana->jenjang_id = $validated['jenjang'];
            $dataPendidikan = DataPendidikan::where('id', $validated['jurusan'])
                ->whereHas('jenjangs', function ($query) use ($validated) {
                    $query->where('jenjangs.id', $validated['jenjang']);
                })
                ->first();
    
            if ($dataPendidikan) {
                $rencana->data_pendidikan_id = $dataPendidikan->id;
                $rencana->jenis_pendidikan_id = $validated['jenis_pendidikan'];
            } else {
                return redirect()->back()->withErrors(['error' => 'Data pendidikan tidak ditemukan.']);
            }
        } elseif ($validated['klasifikasi'] == 'pelatihan') {
            // Tangani klasifikasi 'pelatihan'
            $dataPelatihan = DataPelatihan::find($validated['nama_pelatihan']);
            if ($dataPelatihan) {
                $rencana->data_pelatihan_id = $dataPelatihan->id;
                $rencana->bentuk_jalur_id = $validated['bentuk_jalur'];  // Pastikan 'bentuk_jalur' ada dalam request
            } else {
                return redirect()->back()->withErrors(['error' => 'Data pelatihan tidak ditemukan.']);
            }
        }
    
        // Simpan data baru setelah diupdate
        $newData = $rencana->getAttributes();
    
        // Bandingkan data lama dan baru
        if ($oldData == $newData) {
            if ($rencana->kelompokCanValidating){
                // Jika tidak ada perubahan, kembalikan dengan pesan error
                flash('Data gagal direvisi! Anda tidak melakukan pembaruan data.')->error();
                return redirect()->back();
            }
            // Jika tidak ada perubahan, kembalikan dengan pesan error
            flash('Data gagal diedit! Anda tidak melakukan pembaruan data.')->error();
            return redirect()->back();
        }
    
        // Jika ada perubahan, periksa apakah status pengajuan masih draft
        if ($rencana->status_pengajuan !== 'draft') {
            // Periksa apakah status revisi sudah sedang_direvisi
            if ($rencana->kelompokCanValidating->status_revisi != 'sedang_direvisi') {
                // Ubah status revisi menjadi sedang_direvisi
                $rencana->kelompokCanValidating->status_revisi = 'sedang_direvisi';
                $rencana->kelompokCanValidating->save();
            }
        }
    
        $rencana->save();
    
        flash('Rencana Pembelajaran berhasil diupdate!')->success();
        return redirect()->route('rencana_pembelajaran.index');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RencanaPembelajaran $rencanaPembelajaran)
    {
        // Cek tenggat waktu
        $deadlineInfo = $this->deadlineService->getDeadlineInfo('perencanaan_pegawai');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;
        
        if (!$isWithinDeadline) {
            flash('Tidak dapat menambahkan rencana pembelajaran di luar tenggat waktu yang ditentukan.')->error();
            return redirect()->route('rencana_pembelajaran.index');
        }
        
        if ($rencanaPembelajaran->kelompokCanValidating && $rencanaPembelajaran->kelompokCanValidating->status == 'disetujui') {
            flash('Rencana pembelajaran ini telah disetujui dan tidak dapat dihapus.')->error();
            return redirect()->back();
        }
        $rencanaPembelajaran->delete();
        flash('Data berhasil dihapus!')->error();
        return redirect()->route('rencana_pembelajaran.index');
    }
    
    public function getKategori()
    {
        $kategori = Kategori::all();
        return response()->json($kategori);
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
                'jp' => $pelatihan->jp,
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

    public function validasiAnggaran(Request $request)
    {
        $request->validate([
            'klasifikasi' => 'required|in:pendidikan,pelatihan',
            'regional' => 'required|exists:regions,id',
            'anggaran_rencana' => 'required|integer',
        ]);
    
        $anggaran = null;
    
        if ($request->klasifikasi === 'pendidikan') {
            $anggaran = DB::table('anggaran_pendidikans')
                ->where('jenjang_id', $request->jenjang)
                ->where('region_id', $request->regional)
                ->first();
        } else {
            $anggaran = DB::table('anggaran_pelatihans')
                ->where('data_pelatihan_id', $request->nama_pelatihan)
                ->where('kategori_id', $request->kategori)
                ->where('region_id', $request->regional)
                ->first();
        }
    
        if (!$anggaran) {
            return response()->json([
                'status' => 'invalid',
                'message' => 'Data anggaran tidak ditemukan untuk pilihan yang dipilih.'
            ]);
        }
    
        $anggaran_rencana = (int) $request->anggaran_rencana;
    
        if ($anggaran_rencana < $anggaran->anggaran_min || $anggaran_rencana > $anggaran->anggaran_maks) {
            return response()->json([
                'status' => 'invalid',
                'message' => "Anggaran harus antara Rp " . number_format($anggaran->anggaran_min, 0, ',', '.') . " - Rp " . number_format($anggaran->anggaran_maks, 0, ',', '.')
            ]);
        }
    
        return response()->json([
            'status' => 'valid'
        ]);
    }
    
    
    

}
