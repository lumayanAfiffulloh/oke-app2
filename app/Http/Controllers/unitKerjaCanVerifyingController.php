<?php
namespace App\Http\Controllers;

use App\Models\CatatanVerifikasi;
use App\Models\Kelompok;
use App\Models\RencanaPembelajaran;
use App\Models\unitKerjaCanVerifying;
use App\Services\DeadlineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class unitKerjaCanVerifyingController extends Controller
{
    protected $deadlineService;

    public function __construct(DeadlineService $deadlineService)
    {
        $this->middleware('can:verifikator');
        $this->deadlineService = $deadlineService;
    }

    public function index(DeadlineService $deadlineService)
    {
        $user = Auth::user();

        // Validasi dasar
        if (! $user->dataPegawai || ! $user->dataPegawai->unitKerja) {
            return redirect()->back()->with('error', 'Anda tidak terdaftar dalam unit kerja manapun.');
        }

        $unitKerjaId = $user->dataPegawai->unit_kerja_id;

        // Dapatkan informasi deadline
        $deadlineInfo     = $deadlineService->getDeadlineInfo('verifikasi_unit_kerja');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;
        $startDate        = $deadlineInfo['start_date'] ?? null;
        $endDate          = $deadlineInfo['end_date'] ?? null;
        $isDeadlineSet    = $deadlineInfo['is_set'] ?? false;

        // Hitung status tenggat
        $daysUntilStart  = $startDate ? now()->diffInDays($startDate, false) : null;
        $isNotStartedYet = $startDate && $daysUntilStart > 0;

        // Ambil data dengan eager loading
        $kelompoks = Kelompok::with([
            'ketua',
            'anggota.rencanaPembelajaran' => function ($query) {
                $query->whereHas('kelompokCanValidating', fn($q) => $q->where('status', 'disetujui'))
                    ->with(['dataPelatihan', 'dataPendidikan', 'bentukJalur', 'region', 'jenjang', 'unitKerjaCanVerifying', 'kelompokCanValidating.catatanValidasiKelompok']);
            },
        ])->whereHas('ketua', fn($q) => $q->where('unit_kerja_id', $unitKerjaId))
            ->get();

        // Format data
        $kelompoksData = $kelompoks->map(function ($kelompok) {
            return [
                'kelompok'                 => $kelompok,
                'rencanaDisetujui'         => $kelompok->anggota->flatMap->rencanaPembelajaran
                    ->filter(fn($r) => optional($r->unitKerjaCanVerifying)->status === 'disetujui'),
                'rencanaDirevisi'          => $kelompok->anggota->flatMap->rencanaPembelajaran
                    ->filter(fn($r) => optional($r->unitKerjaCanVerifying)->status === 'direvisi'),
                'rencanaBelumDiverifikasi' => $kelompok->anggota->flatMap->rencanaPembelajaran
                    ->filter(fn($r) => ! optional($r->unitKerjaCanVerifying)->status),
            ];
        });

        return view('verifikasi_index', [
            'kelompoksData'    => $kelompoksData,
            'unitKerja'        => $user->dataPegawai->unitKerja,
            'namaPegawai'      => $user->dataPegawai->nama,
            'isWithinDeadline' => $isWithinDeadline,
            'isNotStartedYet'  => $isNotStartedYet,
            'isDeadlineSet'    => $isDeadlineSet,
            'startDate'        => $startDate,
            'endDate'          => $endDate,
            'daysUntilStart'   => $daysUntilStart,
        ]);
    }

    public function setujui(Request $request, $id)
    {
        $rencana = RencanaPembelajaran::findOrFail($id);

        // Cek tenggat waktu verifikasi unit kerja
        $deadlineInfo     = $this->deadlineService->getDeadlineInfo('verifikasi_unit_kerja');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;

        if (! $isWithinDeadline) {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Tidak dapat menyetujui rencana pembelajaran di luar tenggat waktu yang ditentukan!');
        }

        // Pastikan rencana sudah disetujui oleh ketua kelompok
        if (! $rencana->kelompokCanValidating || $rencana->kelompokCanValidating->status !== 'disetujui') {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Rencana pembelajaran belum disetujui oleh ketua kelompok!');
        }

        // Ambil pegawai yang sedang login
        $pegawai = Auth::user()->dataPegawai;

        // Cek apakah pegawai adalah bagian dari unit kerja yang sama dengan pemilik rencana
        if ($pegawai->unit_kerja_id !== $rencana->dataPegawai->unit_kerja_id) {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Anda tidak memiliki akses untuk memverifikasi rencana pembelajaran ini!');
        }

        // Buat atau update verifikasi
        $verifikasi = unitKerjaCanVerifying::updateOrCreate(
            [
                'data_pegawai_id'         => $pegawai->id,
                'rencana_pembelajaran_id' => $rencana->id,
            ],
            [
                'status'        => 'disetujui',
                'status_revisi' => 'disetujui',
            ]
        );

        // Simpan catatan verifikasi jika ada
        if ($request->catatan) {
            CatatanVerifikasi::create([
                'unit_kerja_can_verifying_id' => $verifikasi->id,
                'catatan'                     => $request->catatan,
            ]);
        }

        return redirect()->route('verifikasi.index')
            ->with('success', 'Rencana berhasil disetujui oleh unit kerja!');
    }

    public function setujuiMassal(Request $request)
    {
        $rencanaIds  = $request->input('rencana_ids', []);
        $catatanUmum = $request->input('catatan', null);

        if (empty($rencanaIds)) {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Tidak ada rencana terpilih!');
        }

        $deadlineInfo     = $this->deadlineService->getDeadlineInfo('verifikasi_unit_kerja');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;

        if (! $isWithinDeadline) {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Tenggat waktu verifikasi unit kerja sudah lewat!');
        }

        $pegawai = Auth::user()->dataPegawai;

        foreach ($rencanaIds as $id) {
            $rencana = RencanaPembelajaran::find($id);

            if (! $rencana) {
                continue;
            }

            if (! $rencana->kelompokCanValidating || $rencana->kelompokCanValidating->status !== 'disetujui') {
                continue;
            }

            if ($pegawai->unit_kerja_id !== $rencana->dataPegawai->unit_kerja_id) {
                continue;
            }

            $verifikasi = unitKerjaCanVerifying::updateOrCreate(
                [
                    'data_pegawai_id'         => $pegawai->id,
                    'rencana_pembelajaran_id' => $rencana->id,
                ],
                [
                    'status'        => 'disetujui',
                    'status_revisi' => 'disetujui',
                ]
            );

            if ($catatanUmum) {
                CatatanVerifikasi::create([
                    'unit_kerja_can_verifying_id' => $verifikasi->id,
                    'catatan'                     => $catatanUmum,
                ]);
            }
        }

        return redirect()->route('verifikasi.index')
            ->with('success', 'Semua rencana terpilih berhasil disetujui!');
    }

    public function revisi(Request $request, $id)
    {
        $rencana = RencanaPembelajaran::findOrFail($id);

        // Cek tenggat waktu verifikasi unit kerja
        $deadlineInfo     = $this->deadlineService->getDeadlineInfo('verifikasi_unit_kerja');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;

        if (! $isWithinDeadline) {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Tidak dapat merevisi rencana pembelajaran di luar tenggat waktu yang ditentukan!');
        }

        // Validasi input
        $request->validate([
            'catatan' => 'required|string|max:500',
        ], [
            'catatan.required' => 'Catatan revisi wajib diisi',
            'catatan.max'      => 'Catatan revisi maksimal 500 karakter',
        ]);

        // Ambil pegawai yang sedang login
        $pegawai = Auth::user()->dataPegawai;

        // Cek apakah pegawai adalah bagian dari unit kerja yang sama dengan pemilik rencana
        if ($pegawai->unit_kerja_id !== $rencana->dataPegawai->unit_kerja_id) {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Anda tidak memiliki akses untuk merevisi rencana pembelajaran ini!');
        }

        // Pastikan rencana sudah disetujui oleh ketua kelompok
        if (! $rencana->kelompokCanValidating || $rencana->kelompokCanValidating->status !== 'disetujui') {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Recnana pembelajaran belum disetujui oleh ketua kelompok!');
        }

        // Buat atau update verifikasi dengan status revisi
        $verifikasi = unitKerjaCanVerifying::updateOrCreate(
            [
                'data_pegawai_id'         => $pegawai->id,
                'rencana_pembelajaran_id' => $rencana->id,
            ],
            [
                'status'        => 'direvisi',
                'status_revisi' => 'belum_direvisi', // Status khusus revisi dari unit kerja
            ]
        );

        // Simpan catatan verifikasi
        CatatanVerifikasi::create([
            'unit_kerja_can_verifying_id' => $verifikasi->id,
            'catatan'                     => $request->catatan,
        ]);

        return redirect()->route('verifikasi.index')
            ->with('success', 'Revisi rencana behrasil dikirim ke pegawai!');
    }

    public function tambahRevisi(Request $request, $id)
    {
        $rencana = RencanaPembelajaran::findOrFail($id);

        // Cek tenggat waktu
        $deadlineInfo     = $this->deadlineService->getDeadlineInfo('verifikasi_unit_kerja');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;

        if (! $isWithinDeadline) {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Tidak dapat menambahkan revisi di luar tenggat waktu yang ditentukan!');
        }

        // Validasi input

        $request->validate([
            'catatan' => 'required|string|max:500',
        ]);

        // Pastikan status revisi sudah dikirim oleh pegawai
        if ($rencana->unitKerjaCanVerifying->status_revisi !== 'sudah_direvisi') {return redirect()->route('verifikasi.index')
                ->with('error', 'Pegawai belum mengirimkan revisi!');}

        // Update status revisi
        $verifikasi = unitKerjaCanVerifying::updateOrCreate(
            [
                'data_pegawai_id'         => Auth::user()->dataPegawai->id,
                'rencana_pembelajaran_id' => $rencana->id,
            ],
            [
                'status'        => 'direvisi',
                'status_revisi' => 'perlu_revisi_ulang',
            ]
        );

        // Simpan catatan revisi tambahan
        CatatanVerifikasi::create([
            'unit_kerja_can_verifying_id' => $verifikasi->id,
            'catatan'                     => $request->catatan,
        ]);

        return redirect()->route('verifikasi.index')
            ->with('success', 'Revisi tambahan behrasil dikirim ke pegawai!');
    }

    public function setujuiDariRevisi(Request $request, $id)
    {
        $rencana = RencanaPembelajaran::findOrFail($id);

        // Cek tenggat waktu
        $deadlineInfo     = $this->deadlineService->getDeadlineInfo('verifikasi_unit_kerja');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;

        if (! $isWithinDeadline) {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Tidak dapat menyetujui revisi di luar tenggat waktu yang ditentukan!');
        }

        // Pastikan status revisi sudah dikirim oleh pegawai
        if ($rencana->unitKerjaCanVerifying->status_revisi !== 'sudah_direvisi') {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Pegawai belum mengirimkan revisi!');
        }

        // Update status verifikasi
        $verifikasi = unitKerjaCanVerifying::updateOrCreate(
            [
                'data_pegawai_id'         => Auth::user()->dataPegawai->id,
                'rencana_pembelajaran_id' => $rencana->id,
            ],
            [
                'status'        => 'disetujui',
                'status_revisi' => 'disetujui_setelah_revisi',
            ]
        );

        // Simpan catatan jika ada
        if ($request->catatan) {
            CatatanVerifikasi::create([
                'unit_kerja_can_verifying_id' => $verifikasi->id,
                'catatan'                     => $request->catatan,
            ]);
        }

        return redirect()->route('verifikasi.index')
            ->with('success', 'Rencana pembelajaran berhasil disetujui!');
    }

    public function destroy($id)
    {
        $validasi = unitKerjaCanVerifying::find($id);

        // Cek tenggat waktu
        $deadlineInfo     = $this->deadlineService->getDeadlineInfo('verifikasi_unit_kerja');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;

        if (! $isWithinDeadline) {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Tidak dapat mengedit verifikasi rencana di luar tenggat waktu yang ditentukan!');
        }

        $catatan = CatatanVerifikasi::where('unit_kerja_can_verifying_id', $validasi->id);
        if ($validasi) {
            $validasi->delete();
            $catatan->delete();
            if ($validasi->status == 'disetujui') {
                return redirect()->route('verifikasi.index')->with('success', 'Persetujuan Rencana Dibatalkan!');
            } elseif ($validasi->status == 'ditolak') {
                return redirect()->route('verifikasi.index')->with('success', 'Penolakan Rencana Dibatalkan!');
            }
        } else {
            return redirect()->route('verifikasi.index')->with('error', 'Data Rencana Tidak Ditemukan!');
        }
    }

    public function batalkanMassal(Request $request)
    {
        $verifikasiIds = $request->input('verifikasi_ids', []);

        if (empty($verifikasiIds)) {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Tidak ada persetujuan terpilih!');
        }

        $deadlineInfo     = $this->deadlineService->getDeadlineInfo('verifikasi_unit_kerja');
        $isWithinDeadline = $deadlineInfo['is_within_deadline'] ?? false;

        if (! $isWithinDeadline) {
            return redirect()->route('verifikasi.index')
                ->with('error', 'Tenggat waktu verifikasi unit kerja sudah lewat!');
        }

        foreach ($verifikasiIds as $id) {
            $validasi = unitKerjaCanVerifying::find($id);
            if (! $validasi) {
                continue;
            }

            // Hapus catatan juga
            CatatanVerifikasi::where('unit_kerja_can_verifying_id', $validasi->id)->delete();
            $validasi->delete();
        }

        return redirect()->route('verifikasi.index')
            ->with('success', 'Persetujuan terpilih berhasil dibatalkan!');
    }

}
