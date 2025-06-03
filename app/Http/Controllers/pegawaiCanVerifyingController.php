<?php
namespace App\Http\Controllers;

use App\Models\CatatanVerifikasi;
use App\Models\Kelompok;
use App\Models\PegawaiCanVerifying;
use App\Models\RencanaPembelajaran;
use App\Services\DeadlineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class pegawaiCanVerifyingController extends Controller
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
                    ->with(['dataPelatihan', 'dataPendidikan', 'bentukJalur', 'region', 'jenjang', 'pegawaiCanVerifying']);
            },
        ])->whereHas('ketua', fn($q) => $q->where('unit_kerja_id', $unitKerjaId))
            ->get();

        // Format data
        $kelompoksData = $kelompoks->map(function ($kelompok) {
            return [
                'kelompok'                 => $kelompok,
                'rencanaDisetujui'         => $kelompok->anggota->flatMap->rencanaPembelajaran
                    ->filter(fn($r) => optional($r->pegawaiCanVerifying)->status === 'disetujui'),
                'rencanaDirevisi'          => $kelompok->anggota->flatMap->rencanaPembelajaran
                    ->filter(fn($r) => optional($r->pegawaiCanVerifying)->status === 'direvisi'),
                'rencanaBelumDiverifikasi' => $kelompok->anggota->flatMap->rencanaPembelajaran
                    ->filter(fn($r) => ! optional($r->pegawaiCanVerifying)->status),
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

    public function deepseek()
    {
        // Dapatkan unit kerja dari user yang login
        $user      = Auth::user();
        $unitKerja = $user->dataPegawai->unitKerja;

        // Dapatkan semua kelompok yang ada di unit kerja ini beserta ketua dan anggotanya
        $kelompoks = Kelompok::with(['ketua', 'anggota'])
            ->whereHas('ketua', function ($query) use ($unitKerja) {
                $query->where('unit_kerja_id', $unitKerja->id);
            })
            ->get();

        // Jika tidak ada kelompok di unit kerja ini
        if ($kelompoks->isEmpty()) {
            return view('verifikasi_index', [
                'kelompoksData' => [],
                'unitKerja'     => $unitKerja,
            ]);
            flash('Tidak ada kelompok.')->error();
        }

        // Dapatkan ID semua anggota dari semua kelompok
        $anggotaIds = collect();
        foreach ($kelompoks as $kelompok) {
            $anggotaIds = $anggotaIds->merge($kelompok->anggota->pluck('id'));
        }

        // Dapatkan semua rencana pembelajaran yang sudah diverifikasi kelompok
        $rencana = RencanaPembelajaran::whereHas('kelompokCanValidating', function ($query) {
            $query->where('status', 'disetujui');
        })
            ->whereIn('data_pegawai_id', $anggotaIds)
            ->with([
                'dataPegawai',
                'dataPegawai.kelompok',
                'dataPelatihan',
                'dataPendidikan',
                'bentukJalur',
                'region',
                'jenjang',
                'kelompokCanValidating',
                'pegawaiCanVerifying',
            ])
            ->get();

        // Kelompokkan berdasarkan kelompok
        $groupedByKelompok = $rencana->groupBy(function ($item) {
            return optional($item->dataPegawai)->kelompok_id;
        });

        // Kemudian dalam setiap kelompok, kelompokkan berdasarkan status verifikasi direksi
        $kelompoksData = [];
        foreach ($groupedByKelompok as $kelompokId => $rencanaKelompok) {
            $kelompok = Kelompok::with('ketua')->find($kelompokId);

            // Skip jika kelompok tidak ditemukan atau tidak memiliki ketua
            if (! $kelompok || ! $kelompok->ketua) {
                continue;
            }

            $kelompoksData[] = [
                'kelompok'                 => $kelompok,
                'rencanaDisetujui'         => $rencanaKelompok->filter(function ($item) {
                    return optional($item->pegawaiCanVerifying)->status === 'disetujui';
                }),
                'rencanaDirevisi'          => $rencanaKelompok->filter(function ($item) {
                    return optional($item->pegawaiCanVerifying)->status === 'direvisi';
                }),
                'rencanaBelumDiverifikasi' => $rencanaKelompok->filter(function ($item) {
                    return is_null(optional($item->pegawaiCanVerifying)->status);
                }),
            ];
        }

        return view('verifikasi_index', [
            'kelompoksData' => $kelompoksData,
            'unitKerja'     => $unitKerja,
        ]);
    }

    public function setujui(Request $request, $rencanaId)
    {
        // Validasi deadline
        $deadlineInfo = $this->deadlineService->getDeadlineInfo('verifikasi_unit_kerja');
        if (! $deadlineInfo['is_within_deadline']) {
            return redirect()->back()
                ->with('error', 'Tidak bisa menyetujui di luar tenggat waktu.');
        }

        $rencana     = RencanaPembelajaran::findOrFail($rencanaId);
        $verifikator = Auth::user()->dataPegawai;

        // Gunakan updateOrCreate untuk menghindari duplikasi
        $verifikasi = PegawaiCanVerifying::updateOrCreate(
            [
                'rencana_pembelajaran_id' => $rencana->id,
                'data_pegawai_id'         => $verifikator->id,
            ],
            [
                'status'        => 'disetujui',
                'status_revisi' => 'disetujui',
            ]
        );

        // Simpan catatan jika ada
        if ($request->filled('catatan')) {
            CatatanVerifikasi::create([
                'pegawai_can_verifying_id' => $verifikasi->id,
                'catatan'                  => $request->catatan,
            ]);
        }

        flash('Rencana berhasil disetujui.')->success();
        return redirect()->route('verifikasi_index');
    }

    public function revisi(Request $request, $rencanaId)
    {
        $request->validate(['catatan' => 'required']);

        $rencana     = RencanaPembelajaran::findOrFail($rencanaId);
        $verifikator = Auth::user()->dataPegawai;

        $verifikasi = PegawaiCanVerifying::updateOrCreate(
            [
                'rencana_pembelajaran_id' => $rencana->id,
                'data_pegawai_id'         => $verifikator->id,
            ],
            [
                'status'        => 'direvisi',
                'status_revisi' => 'sedang direvisi',
            ]
        );

        CatatanVerifikasi::create([
            'pegawai_can_verifying_id' => $verifikasi->id,
            'catatan'                  => $request->catatan,
        ]);

        // Optional: Update status rencana ke 'direvisi_unit_kerja'
        $rencana->update(['status_pengajuan' => 'direvisi_unit_kerja']);

        flash('Revisi rencana berhasil dikirim ke pegawai.')->warning();
        return redirect()->route('verifikasi.index');
    }
}
