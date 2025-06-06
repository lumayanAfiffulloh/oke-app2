<?php

namespace App\Http\Controllers;
use App\Models\Region;
use App\Models\Rumpun;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\DataPelatihan;
use App\Models\AnggaranPelatihan;
use Illuminate\Support\Facades\DB;
use App\Imports\DataPelatihanImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreDataPelatihanRequest;
use App\Http\Requests\UpdateDataPelatihanRequest;
use Maatwebsite\Excel\Validators\ValidationException;

class DataPelatihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataPelatihan = DataPelatihan::with('anggaranPelatihan', 'rumpun')->latest()->get();

        return view('data_pelatihan_index', compact('dataPelatihan'));
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
    public function store(StoreDataPelatihanRequest $request)
    {
        // Validasi sudah dilakukan di StoreDataPelatihanRequest
        $requestData = $request->validated();

        DB::transaction(function () use ($requestData) {
            // Simpan data rumpun jika belum ada
            $rumpun = Rumpun::firstOrCreate(['rumpun' => $requestData['rumpun']]);

            // Simpan data pelatihan
            $dataPelatihan = DataPelatihan::create([
                'rumpun_id' => $rumpun->id,
                'kode' => $requestData['kode'],
                'nama_pelatihan' => $requestData['nama_pelatihan'],
                'deskripsi' => $requestData['deskripsi'],
                'jp' => $requestData['jp'],
                'materi' => $requestData['materi'],
            ]);

            // Data anggaran harga nasional dan internasional
            $anggaranPelatihanData = [
                [
                    'data_pelatihan_id' => $dataPelatihan->id,
                    'region_id' => Region::where('region', 'nasional')->first()->id, // Ambil ID region nasional
                    'kategori_id' => Kategori::where('kategori', 'klasikal')->first()->id, // Ambil ID kategori klasikal
                    'anggaran_min' => $requestData['nasional_klasikal_min'] ?? null,
                    'anggaran_maks' => $requestData['nasional_klasikal_maks'] ?? null,
                ],
                [
                    'data_pelatihan_id' => $dataPelatihan->id,
                    'region_id' => Region::where('region', 'nasional')->first()->id, // Ambil ID region nasional
                    'kategori_id' => Kategori::where('kategori', 'non-klasikal')->first()->id, // Ambil ID kategori non-klasikal
                    'anggaran_min' => $requestData['nasional_non-klasikal_min'] ?? null,
                    'anggaran_maks' => $requestData['nasional_non-klasikal_maks'] ?? null,
                ],
                [
                    'data_pelatihan_id' => $dataPelatihan->id,
                    'region_id' => Region::where('region', 'internasional')->first()->id, // Ambil ID region internasional
                    'kategori_id' => Kategori::where('kategori', 'klasikal')->first()->id, // Ambil ID kategori klasikal
                    'anggaran_min' => $requestData['internasional_klasikal_min'] ?? null,
                    'anggaran_maks' => $requestData['internasional_klasikal_maks'] ?? null,
                ],
                [
                    'data_pelatihan_id' => $dataPelatihan->id,
                    'region_id' => Region::where('region', 'internasional')->first()->id, // Ambil ID region internasional
                    'kategori_id' => Kategori::where('kategori', 'non-klasikal')->first()->id, // Ambil ID kategori non-klasikal
                    'anggaran_min' => $requestData['internasional_non-klasikal_min'] ?? null,
                    'anggaran_maks' => $requestData['internasional_non-klasikal_maks'] ?? null,
                ],
            ];

            // Simpan data anggaran harga
            foreach ($anggaranPelatihanData as $anggaran) {
                if ($anggaran['anggaran_min'] !== null || $anggaran['anggaran_maks'] !== null) {
                    AnggaranPelatihan::create($anggaran);
                }
            }
        });

        // Flash message sukses
        flash('Data pelatihan dan anggaran harga berhasil ditambahkan')->success();

        // Redirect ke halaman index
        return redirect()->route('data_pelatihan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataPelatihan $dataPelatihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dataPelatihan = DataPelatihan::with(['rumpun', 'anggaranPelatihan'])->findOrFail($id);
        $rumpuns = Rumpun::all();

        return view('data_pelatihan_edit', compact('dataPelatihan', 'rumpuns'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDataPelatihanRequest $request, $id)
    {
        // Ambil data pelatihan berdasarkan ID
        $dataPelatihan = DataPelatihan::findOrFail($id);

        // Update data pelatihan
        $dataPelatihan->update([
            'kode' => $request->kode,
            'rumpun_id' => $request->rumpun_id,
            'nama_pelatihan' => $request->nama_pelatihan,
            'deskripsi' => $request->deskripsi,
            'jp' => $request->jp,
            'materi' => $request->materi,
        ]);

        // Update data anggaran pelatihan
        if ($request->has('anggaran')) {
            foreach ($request->anggaran as $anggaranId => $anggaranData) {
                $anggaran = AnggaranPelatihan::findOrFail($anggaranId);
                $anggaran->update([
                    'anggaran_min' => (int) str_replace('.', '', $anggaranData['anggaran_min']),
                    'anggaran_maks' => (int) str_replace('.', '', $anggaranData['anggaran_maks']),
                ]);
            }
        }

        // Flash message sukses
        flash('Data pelatihan berhasil diupdate')->success();

        // Redirect ke halaman index
        return redirect()->route('data_pelatihan.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataPelatihan $dataPelatihan)
    {
        $dataPelatihan->delete();
        flash('Data berhasil dihapus!')->error();
        return redirect()->route('data_pelatihan.index');
    }

    public function importExcelData(Request $request)
    {
        $request->validate([
            'importDataPelatihan' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv', // Validasi tipe file
            ],
        ], [
            'importDataPelatihan.required' => 'File impor wajib diunggah.',
            'importDataPelatihan.file' => 'Berkas harus berupa file.',
            'importDataPelatihan.mimes' => 'Format file harus berupa xlsx, xls, atau csv.',
        ]);

        try {
            // Gunakan import class yang sudah dibuat
            Excel::import(new DataPelatihanImport, $request->file('importDataPelatihan'));

            flash('Data berhasil diimport!')->success();
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorMessage = "Gagal mengimpor data. Periksa file Anda.";

            foreach ($failures as $failure) {
                $errorMessage .= " Baris: {$failure->row()}, Kolom: " . implode(', ', $failure->attribute());
            }

            flash($errorMessage)->error();
        } catch (\Exception $e) {
            flash('Import File Gagal. Pastikan format file sesuai dengan template!')->error();
        }

        return redirect()->route('data_pelatihan.index');
    }
}
