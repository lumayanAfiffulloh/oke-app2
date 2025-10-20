<?php
namespace App\Http\Controllers;

use App\Models\CatatanValidasiKelompok;
use App\Models\Kelompok;
use App\Models\KelompokCanValidating;
use App\Models\RencanaPembelajaran;
use App\Services\DeadlineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function index(DeadlineService $deadlineService)
    {
        // Ambil ketua kelompok (user yang sedang login)
        $ketuaKelompok = Auth::user()->dataPegawai;

        // Dapatkan informasi deadline

        // Dapatkan informasi deadline
        $deadlineInfo     = $deadlineService->getDeadlineInfo('validasi_kelompok');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;
        $startDate        = $deadlineInfo['start_date'] ?? null;
        $endDate          = $deadlineInfo['end_date'] ?? null;
        $isDeadlineSet    = $deadlineInfo['is_set'] ?? false;

        // Hitung status tenggat
        $daysUntilStart  = $startDate ? now()->diffInDays($startDate, false) : null;
        $isNotStartedYet = $startDate && $daysUntilStart > 0;

        // Ambil kelompok yang dipimpin oleh ketua kelompok beserta anggota dan validasinya
        $kelompok = Kelompok::with(['anggota', 'ketua.unitKerja', 'kelompokCanValidating'])
            ->where('id_ketua', $ketuaKelompok->id)
            ->first();

        if (! $kelompok) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki kelompok.');
        }

        // Ambil semua anggota kelompok
        $anggota = $kelompok->anggota;

        // Ambil semua rencana pembelajaran milik anggota kelompok yang statusnya "diajukan"
        $rencana = RencanaPembelajaran::whereIn('data_pegawai_id', $anggota->pluck('id'))
            ->where('status_pengajuan', 'diajukan') // Tambahkan filter status_pengajuan
            ->with(['dataPegawai', 'dataPelatihan', 'dataPendidikan', 'bentukJalur', 'region', 'jenjang', 'kelompokCanValidating.catatanValidasiKelompok'])
            ->get();

        // Mengelompokkan data berdasarkan status validasi
        $rencanaDisetujui       = $rencana->filter(fn($item) => optional($item->kelompokCanValidating)->status === 'disetujui');
        $rencanaDirevisi        = $rencana->filter(fn($item) => optional($item->kelompokCanValidating)->status === 'direvisi');
        $rencanaBelumDivalidasi = $rencana->filter(fn($item) => is_null(optional($item->kelompokCanValidating)->status));

        $totalRencana     = $rencana->count();
        $totalDisetujui   = $rencanaDisetujui->count();
        $totalPerluRevisi = $rencanaDirevisi->count();

        return view('validasi_kelompok_index', [
            'anggota'                => $anggota,
            'rencana'                => $rencana,
            'rencanaDisetujui'       => $rencanaDisetujui,
            'rencanaDirevisi'        => $rencanaDirevisi,
            'rencanaBelumDivalidasi' => $rencanaBelumDivalidasi,
            'kelompok'               => $kelompok,
            'isWithinDeadline'       => $isWithinDeadline,
            'isNotStartedYet'        => $isNotStartedYet,
            'isDeadlineSet'          => $isDeadlineSet,
            'startDate'              => $startDate,
            'endDate'                => $endDate,
            'daysUntilStart'         => $daysUntilStart,
            'totalRencana'           => $totalRencana,
            'totalDisetujui'         => $totalDisetujui,
            'totalPerluRevisi'       => $totalPerluRevisi,
        ]);
    }

    public function setujui(Request $request, $id)
    {
        $rencana = RencanaPembelajaran::findOrFail($id);

        // Cek tenggat waktu
        $deadlineInfo     = $this->deadlineService->getDeadlineInfo('validasi_kelompok');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;

        if (! $isWithinDeadline) {
            return redirect()->route('validasi_kelompok.index')
                ->with('error', 'Tidak dapat menyetujui rencana pembelajaran di luar tenggat waktu yang dittentukan!');
        }

        // Ambil ketua kelompok yang sedang login
        $ketuaKelompok = Auth::user()->dataPegawai;

        // Ambil kelompok yang dipimpin oleh ketua
        $kelompok = Kelompok::where('id_ketua', $ketuaKelompok->id)->first();

        if (! $kelompok) {
            return redirect()->back()->with('error', 'Anda tidak memiliki kelompok.');
        }

        // Simpan validasi
        $validasi = KelompokCanValidating::updateOrCreate([
            'rencana_pembelajaran_id' => $rencana->id,
            'kelompok_id'             => $kelompok->id,
            'status'                  => 'disetujui',
            'status_revisi'           => 'disetujui',
        ]);

        // Simpan catatan validasi kelompok jika catatan tidak kosong
        if ($request->catatan) {
            CatatanValidasiKelompok::create([
                'kelompok_can_validating_id' => $validasi->id,
                'catatan'                    => $request->catatan,
            ]);
        }

        return redirect()->route('validasi_kelompok.index')
            ->with('success', 'Rencana Berhasil Disetujui!');
    }

    public function revisi(Request $request, $id)
    {
        $rencana = RencanaPembelajaran::findOrFail($id);

        // Cek tenggat waktu
        $deadlineInfo     = $this->deadlineService->getDeadlineInfo('validasi_kelompok');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;

        if (! $isWithinDeadline) {
            return redirect()->route('validasi_kelompok.index')
                ->with('error', 'Tidak dapat merevisi rencana pembelajaran di luar tenggat waktu yang ditentukan.!');
        }

        // Ambil ketua kelompok yang sedang login
        $ketuaKelompok = Auth::user()->dataPegawai;

        // Ambil kelompok yang dipimpin oleh ketua
        $kelompok = Kelompok::where('id_ketua', $ketuaKelompok->id)->first();

        if (! $kelompok) {
            return redirect()->back()->with('error', 'Anda tidak memiliki kelompok.');
        }

        // Simpan validasi
        $validasi = KelompokCanValidating::updateOrCreate([
            'rencana_pembelajaran_id' => $rencana->id,
            'kelompok_id'             => $kelompok->id,
            'status'                  => 'direvisi',
            'status_revisi'           => "belum_direvisi",
        ]);

        // Simpan catatan validasi kelompok
        CatatanValidasiKelompok::create([
            'kelompok_can_validating_id' => $validasi->id,
            'catatan'                    => $request->catatan,
        ]);

        return redirect()->route('validasi_kelompok.index')
            ->with('warning', 'Revisi rencana behrasil dikirim ke pegawai!');
    }

    public function setujuiDariRevisi(Request $request, $id)
    {
        // Cari data validasi berdasarkan ID rencana
        $validasi = KelompokCanValidating::where('rencana_pembelajaran_id', $id)->first();

        // Cek tenggat waktu
        $deadlineInfo     = $this->deadlineService->getDeadlineInfo('validasi_kelompok');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;

        if (! $isWithinDeadline) {
            return redirect()->route('validasi_kelompok.index')
                ->with('error', 'Tidak dapat menyetujui rencana pembelajaran di luar tenggat waktu yang ditentukan!');
        }

        if (! $validasi) {
            return redirect()->back()
                ->with('error', 'Data validasi tidak ditemukan!');

        }

        // Cek apakah status_revisi sudah "sudah_direvisi"
        if ($validasi->status_revisi !== 'sudah_direvisi') {
            return redirect()->back()
                ->with('error', 'Revisi belum selesai, silakan minta revisi kepada pegawai terkait!');
        }

        // Update status menjadi "disetujui" dan hapus status revisi
        $validasi->update([
            'status'        => 'disetujui',
            'status_revisi' => 'disetujui',
        ]);

        // Hapus catatan validasi sebelumnya
        CatatanValidasiKelompok::where('kelompok_can_validating_id', $validasi->id)->delete();

        // Jika pengguna memasukkan catatan baru, simpan catatan tersebut
        if ($request->filled('catatan')) {
            CatatanValidasiKelompok::create([
                'kelompok_can_validating_id' => $validasi->id,
                'catatan'                    => $request->catatan,
            ]);
        }

        return redirect()->route('validasi_kelompok.index')
            ->with('success', 'Rencana berhasil disetujui!');
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
        $deadlineInfo     = $this->deadlineService->getDeadlineInfo('validasi_kelompok');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;

        if (! $isWithinDeadline) {
            return redirect()->route('validasi_kelompok.index')
                ->with('error', 'Tidak dapat menambah revisi rencana pembelajaran di luar tenggat waktu yang ditentukan!');
        }

        // Ambil ketua kelompok yang sedang login
        $ketuaKelompok = Auth::user()->dataPegawai;

        // Ambil kelompok yang dipimpin oleh ketua
        $kelompok = Kelompok::where('id_ketua', $ketuaKelompok->id)->first();

        if (! $kelompok) {
            return redirect()->back()->with('error', 'Anda tidak memiliki kelompok.');
        }

        // Cari verifikasi terakhir untuk rencana pembelajaran ini
        $verifikasiTerakhir = KelompokCanValidating::where('rencana_pembelajaran_id', $rencana->id)
            ->where('kelompok_id', $kelompok->id)
            ->latest() // Ambil verifikasi terbaru
            ->first();

        // Jika verifikasi terakhir tidak ditemukan, kembalikan error
        if (! $verifikasiTerakhir) {
            return redirect()->back()->with('error', 'Verifikasi tidak ditemukan.');
        }

        // Update status verifikasi menjadi "direvisi"
        $verifikasiTerakhir->update([
            'status'        => 'direvisi',
            'status_revisi' => 'belum_direvisi', // Set status revisi ke "belum_direvisi"
        ]);

        // Tambahkan catatan revisi baru ke tabel CatatanVerifikasiKelompok
        CatatanValidasiKelompok::create([
            'kelompok_can_validating_id' => $verifikasiTerakhir->id,
            'catatan'                    => $request->catatan,
        ]);

        return redirect()->route('validasi_kelompok.index')
            ->with('warning', 'Revisi berhasil ditambahkan!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $validasi = KelompokCanValidating::find($id);

        // Cek tenggat waktu
        $deadlineInfo     = $this->deadlineService->getDeadlineInfo('validasi_kelompok');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;

        if (! $isWithinDeadline) {
            return redirect()->route('validasi_kelompok.index')
                ->with('error', 'Tidak dapat mengedit validasi rencana pembelajaran di luar tenggat waktu yang ditentukan!');
        }

        $catatan = CatatanValidasiKelompok::where('kelompok_can_validating_id', $validasi->id);
        if ($validasi) {
            $validasi->delete();
            $catatan->delete();
            if ($validasi->status == 'disetujui') {
                $message = 'Persetujuan rencana dibatalkan!';
                $type    = 'success';
            } elseif ($validasi->status == 'ditolak') {
                $message = 'Penolakan rencana dibatalkan!';
                $type    = 'success';
            }
            return redirect()->route('validasi_kelompok.index')->with($type, $message);
        } else {
            return redirect()->route('validasi_kelompok.index')->with('error', 'Data rencana tidak ditemukan!');
        }
    }
}
