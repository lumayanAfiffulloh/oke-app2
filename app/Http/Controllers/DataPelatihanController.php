<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\DataPelatihan;
use App\Models\EstimasiHarga;
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
        $dataPelatihan = DataPelatihan::with('estimasiHarga')->latest()->get();

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
            // Simpan data pelatihan
            $dataPelatihan = DataPelatihan::create([
                'kode' => $requestData['kode'],
                'rumpun' => $requestData['rumpun'],
                'nama_pelatihan' => $requestData['nama_pelatihan'],
                'deskripsi' => $requestData['deskripsi'],
                'jp' => $requestData['jp'],
                'materi' => $requestData['materi'],
            ]);

            // Data estimasi harga nasional dan internasional
            $estimasiHargaData = [
                [
                    'pelatihan_id' => $dataPelatihan->id,
                    'region' => 'nasional',
                    'kategori' => 'klasikal',
                    'anggaran_min' => $requestData['nasional_klasikal_min'] ?? null,
                    'anggaran_maks' => $requestData['nasional_klasikal_maks'] ?? null,
                ],
                [
                    'pelatihan_id' => $dataPelatihan->id,
                    'region' => 'nasional',
                    'kategori' => 'non-klasikal',
                    'anggaran_min' => $requestData['nasional_non-klasikal_min'] ?? null,
                    'anggaran_maks' => $requestData['nasional_non-klasikal_maks'] ?? null,
                ],
                [
                    'pelatihan_id' => $dataPelatihan->id,
                    'region' => 'internasional',
                    'kategori' => 'klasikal',
                    'anggaran_min' => $requestData['internasional_klasikal_min'] ?? null,
                    'anggaran_maks' => $requestData['internasional_klasikal_maks'] ?? null,
                ],
                [
                    'pelatihan_id' => $dataPelatihan->id,
                    'region' => 'internasional',
                    'kategori' => 'non-klasikal',
                    'anggaran_min' => $requestData['internasional_non-klasikal_min'] ?? null,
                    'anggaran_maks' => $requestData['internasional_non-klasikal_maks'] ?? null,
                ],
            ];

            // Simpan data estimasi harga
            foreach ($estimasiHargaData as $estimasi) {
                if ($estimasi['anggaran_min'] !== null || $estimasi['anggaran_maks'] !== null) {
                    EstimasiHarga::create($estimasi);
                }
            }
        });

        // Flash message sukses
        flash('Data pelatihan dan estimasi harga berhasil ditambahkan')->success();

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
    public function edit(DataPelatihan $dataPelatihan)
    {
        $dataPelatihan->load('estimasiHarga');

        return view('data_pelatihan_edit', compact('dataPelatihan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDataPelatihanRequest $request, DataPelatihan $dataPelatihan)
    {
        $requestData = $request->validated();

        DB::transaction(function () use ($requestData, $dataPelatihan) {
            // Update data pelatihan
            $dataPelatihan->update([
                'kode' => $requestData['kode'],
                'rumpun' => $requestData['rumpun'],
                'nama_pelatihan' => $requestData['nama_pelatihan'],
                'deskripsi' => $requestData['deskripsi'],
                'jp' => $requestData['jp'],
                'materi' => $requestData['materi'],
            ]);

            // Update data estimasi harga
            if (isset($requestData['estimasi'])) {
                foreach ($requestData['estimasi'] as $id => $estimasiData) {
                    $estimasi = EstimasiHarga::find($id);
                    if ($estimasi && $estimasi->pelatihan_id == $dataPelatihan->id) {
                        $estimasi->update([
                            'anggaran_min' => $estimasiData['anggaran_min'],
                            'anggaran_maks' => $estimasiData['anggaran_maks'],
                        ]);
                    }
                }
            }
        });

        flash('Data pelatihan dan estimasi harga berhasil diperbarui')->success();
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
