<?php

namespace App\Http\Controllers;

use App\Models\Jenjang;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Models\DataPendidikan;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataPendidikanImport;
use App\Http\Requests\StoreDataPendidikanRequest;
use App\Http\Requests\UpdateDataPendidikanRequest;
use Maatwebsite\Excel\Validators\ValidationException;

class DataPendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua DataPendidikan dengan relasi 'jenjangs', dan 'jurusan'
        $dataPendidikan = DataPendidikan::with(['jenjangs'])->latest()->get();
        $jenjangs = Jenjang::whereIn('jenjang', ['S1', 'S2', 'S3'])->get();
        $jenjangsAll = Jenjang::all();
        return view('data_pendidikan_index', compact('dataPendidikan', 'jenjangs', 'jenjangsAll'));
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
    public function store(StoreDataPendidikanRequest $request)
    {
        $requestData = $request->validated();

        // Simpan data pendidikan
        $dataPendidikan = DataPendidikan::create([
            'jurusan' => $requestData['jurusan'],
        ]);

        // Simpan relasi jenjang
        foreach ($requestData['jenjang'] as $jenjang) {
            // Cek atau buat data jenjang jika belum ada
            $jenjangObj = Jenjang::firstOrCreate(['jenjang' => $jenjang]);

            // Tambahkan relasi ke tabel pivot
            $dataPendidikan->jenjangs()->attach($jenjangObj->id);
        }

        // Flash message sukses
        flash('Data pendidikan berhasil ditambahkan')->success();

        // Redirect ke halaman index
        return redirect()->route('data_pendidikan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataPendidikan $dataPendidikan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataPendidikan $dataPendidikan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDataPendidikanRequest $request, DataPendidikan $dataPendidikan)
    {
        // Validasi data yang dikirim
        $validatedData = $request->validated();
    
        // Hapus kolom 'jenjang' dari array validatedData
        unset($validatedData['jenjang']);
    
        // Perbarui data pendidikan
        $dataPendidikan->update($validatedData);
    
        // Perbarui data jenjang
        if (isset($request->jenjang)) {
            // Ambil atau buat jenjang baru, lalu sinkronkan dengan data pendidikan
            $jenjangIds = [];
            foreach ($request->jenjang as $jenjang) {
                $jenjangObj = Jenjang::firstOrCreate(['jenjang' => $jenjang]);
                $jenjangIds[] = $jenjangObj->id;
            }
            $dataPendidikan->jenjangs()->sync($jenjangIds);
        } else {
            // Jika jenjang kosong, hapus semua relasi jenjang
            $dataPendidikan->jenjangs()->detach();
        }
    
        // Flash message sukses
        flash('Data pendidikan berhasil diperbarui')->success();
    
        // Redirect ke halaman index
        return redirect()->route('data_pendidikan.index');
    }

    public function destroy(DataPendidikan $dataPendidikan)
    {
        // Menghapus relasi many-to-many dengan tabel jenjangs
        $dataPendidikan->jenjangs()->detach();
    
        // Menghapus data pendidikan
        $dataPendidikan->delete();
    
        // Flash message sukses
        flash('Data pendidikan berhasil dihapus')->error();
    
        // Redirect ke halaman index
        return redirect()->route('data_pendidikan.index');
    }

    public function importExcelData(Request $request)
    {
        // Validasi file Excel
        $request->validate([
            'importDataPendidikan' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv', // Validasi tipe file
            ],
        ], [
            'importDataPendidikan.required' => 'File impor wajib diunggah.',
            'importDataPendidikan.file' => 'Berkas harus berupa file.',
            'importDataPendidikan.mimes' => 'Format file harus berupa xlsx, xls, atau csv.',
        ]);
    
        try {
            // Gunakan class import yang sudah dibuat
            Excel::import(new DataPendidikanImport, $request->file('importDataPendidikan'));
    
            flash('Data pendidikan berhasil diimpor!')->success();
        } catch (ValidationException $e) {
            // Tangani kesalahan validasi dan tampilkan baris serta kolom yang gagal
            $failures = $e->failures();
            $errorMessage = "Gagal mengimpor data. Periksa file Anda.";
    
            foreach ($failures as $failure) {
                $errorMessage .= " Baris: {$failure->row()}, Kolom: " . implode(', ', $failure->attribute());
            }
    
            flash($errorMessage)->error();
        } catch (\Exception $e) {
            // Tangani kesalahan lain (misalnya kesalahan format file)
            flash('Import file gagal. Pastikan format file sesuai dengan template!')->error();
        }
    
        // Kembali ke halaman sebelumnya
        return redirect()->route('data_pendidikan.index');
    }
    

}
