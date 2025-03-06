<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\KelompokController;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Controllers\EditAksesController;
use App\Http\Controllers\BentukJalurController;
use App\Http\Controllers\DataPegawaiController;
use App\Http\Controllers\TenggatWaktuController;
use App\Http\Controllers\DataPelatihanController;
use App\Http\Controllers\DataPendidikanController;
use App\Http\Controllers\AnggotaKelompokController;
use App\Http\Controllers\VerifikasiKelompokController;
use App\Http\Controllers\RencanaPembelajaranController;

Route::middleware([Authenticate::class, 'check.default.password'])->group(function () {
    
    Route::resource('data_pegawai', DataPegawaiController::class);
    Route::post('/data_pegawai/import', [DataPegawaiController::class, 'importExcelData']);

    Route::resource('rencana_pembelajaran', RencanaPembelajaranController::class);

    // VERIFIKASI KELOMPOK
    Route::post('/rencana/{id}/ajukan', [RencanaPembelajaranController::class, 'ajukanVerifikasi'])
    ->name('rencana.ajukan');
    // routes/web.php
    Route::post('/rencana_pembelajaran/{id}/kirim_revisi', [RencanaPembelajaranController::class, 'kirimRevisi'])->name('rencana_pembelajaran.kirim_revisi');

    Route::get('/get-bentuk-jalur/{kategori_id}', [RencanaPembelajaranController::class, 'getBentukJalur']);
    Route::get('/get-jenjang', [RencanaPembelajaranController::class, 'getJenjang']);
    Route::get('/get-jurusan-by-jenjang', [RencanaPembelajaranController::class, 'getJurusanByJenjang']);
    Route::get('/get-rumpun', [RencanaPembelajaranController::class, 'getRumpun']);
    Route::get('/nama-pelatihan/{rumpunId}', [RencanaPembelajaranController::class, 'getNamaPelatihan']);
    Route::get('/get-jenis-pendidikan', [RencanaPembelajaranController::class, 'getJenisPendidikan']);
    Route::get('/get-pelatihan-info/{id}', [RencanaPembelajaranController::class, 'getPelatihanInfo']);
    Route::get('/get-anggaran-by-pendidikan', [RencanaPembelajaranController::class, 'getAnggaranByPendidikan']);
    Route::get('/get-anggaran-by-pelatihan', [RencanaPembelajaranController::class, 'getAnggaranByPelatihan']);
    Route::get('/get-kategori-by-klasifikasi', [RencanaPembelajaranController::class, 'getKategori']);
    Route::post('/validasi-anggaran', [RencanaPembelajaranController::class, 'validasiAnggaran']);
    Route::get('/getPelatihanDetail/{id}', [RencanaPembelajaranController::class, 'getPelatihanDetail']);
    
    Route::resource('edit_akses', EditAksesController::class);

    Route::resource('data_pelatihan', DataPelatihanController::class);
    Route::post('/data_pelatihan/import', [DataPelatihanController::class, 'importExcelData']);

    Route::resource('data_pendidikan', DataPendidikanController::class);
    Route::post('/data_pendidikan/import', [DataPendidikanController::class, 'importExcelData']);

    Route::resource('bentuk_jalur', BentukJalurController::class);
    
    Route::resource('kelompok', KelompokController::class);
    
    Route::post('/kelompok/reset', [KelompokController::class, 'reset']);
    
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil');
    
    Route::post('/profil/tambah_foto', [ProfilController::class, 'processFoto']);

    Route::post('/profil/ganti_foto', [ProfilController::class, 'processFoto']);

    Route::resource('verifikasi_kelompok', VerifikasiKelompokController::class);
    Route::post('/verifikasi/setujui', [VerifikasiKelompokController::class, 'setujui'])->name('verifikasi.setujui');
    Route::post('/verifikasi/tolak', [VerifikasiKelompokController::class, 'tolak'])->name('verifikasi.tolak');
    
    Route::resource('anggota_kelompok', AnggotaKelompokController::class);

    Route::get('/tenggat_waktu', [TenggatWaktuController::class, 'show'])->name('tenggatWaktu');
});

Route::get('/ganti_password', [ProfilController::class, 'changePassword']);

Route::post('/ganti_password', [ProfilController::class, 'processPassword']);

Route::get('/', function () {
    // Jika pengguna sudah login, arahkan ke /profil
    if (Auth::check()) {
        return redirect('profil');
    }
    return view('welcome');
});

Auth::routes(); 


