<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreDataPendidikanRequest;
use App\Http\Requests\UpdateDataPendidikanRequest;
use App\Imports\DataPendidikanImport;
use App\Models\DataPendidikan;
use App\Models\Jenjang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
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
        $jenjangs       = Jenjang::whereIn('jenjang', ['S1', 'S2', 'S3'])->get();
        $jenjangsAll    = Jenjang::all();
        return view('data_pendidikan_index', compact('dataPendidikan', 'jenjangs', 'jenjangsAll'));
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

        $jenjangIds = Jenjang::whereIn('jenjang', $requestData['jenjang'])
            ->pluck('id')
            ->toArray();

        // Tambahkan relasi ke tabel pivot
        $dataPendidikan->jenjangs()->attach($jenjangIds);

        return redirect()->route('data_pendidikan.index')
            ->with('success', 'Data pendidikan berhasil ditambahkan!');
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
        if (! empty($request->jenjang)) {
            // Ambil ID jenjang dari database (tanpa membuat baru)
            $jenjangIds = Jenjang::whereIn('jenjang', $request->jenjang)
                ->pluck('id')
                ->toArray();

            // Sinkronkan relasi
            $dataPendidikan->jenjangs()->sync($jenjangIds);
        } else {
            // Jika jenjang kosong, hapus semua relasi jenjang
            $dataPendidikan->jenjangs()->detach();
        }

        return redirect()->route('data_pendidikan.index')
            ->with('success', 'Data pendidikan berhasil diperbarui!');
    }

    public function destroy(DataPendidikan $dataPendidikan)
    {
        // Menghapus relasi many-to-many dengan tabel jenjangs
        $dataPendidikan->jenjangs()->detach();

        // Menghapus data pendidikan
        $dataPendidikan->delete();

        return redirect()->route('data_pendidikan.index')
            ->with('error', 'Data pendidikan berhasil dihapus!');
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
            'importDataPendidikan.file'     => 'Berkas harus berupa file.',
            'importDataPendidikan.mimes'    => 'Format file harus berupa xlsx, xls, atau csv.',
        ]);

        try {
            // Gunakan class import yang sudah dibuat
            Excel::import(new DataPendidikanImport, $request->file('importDataPendidikan'));

            return redirect()->route('data_pendidikan.index')->with('success', 'Data pendidikan berhasil diimpor!');
        } catch (ValidationException $e) {
            // Tangani kesalahan validasi dan tampilkan baris serta kolom yang gagal
            $failures     = $e->failures();
            $errorMessage = "Gagal mengimpor data. Periksa file Anda.";

            foreach ($failures as $failure) {
                $errorMessage .= " Baris: {$failure->row()}, Kolom: " . implode(', ', $failure->attribute());
            }

            return redirect()->route('data_pendidikan.index')->with('error', $errorMessage);
        } catch (\Exception $e) {
            // Tangani kesalahan lain (misalnya kesalahan format file)
            return redirect()->route('data_pendidikan.index')->with('error', 'Impor file gagal. Pastikan format file sesuai dengan template!');
        }
    }

}
