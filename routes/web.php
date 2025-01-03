<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\KelompokController;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Controllers\EditAksesController;
use App\Http\Controllers\BentukJalurController;
use App\Http\Controllers\DataPegawaiController;
use App\Http\Controllers\DataPelatihanController;
use App\Http\Controllers\DataPendidikanController;
use App\Http\Controllers\RencanaPembelajaranController;


Route::middleware([Authenticate::class, 'check.default.password'])->group(function () {
    
    Route::resource('data_pegawai', DataPegawaiController::class);
    Route::post('/data_pegawai/import', [DataPegawaiController::class, 'importExcelData']);

    Route::resource('rencana_pembelajaran', RencanaPembelajaranController::class);
    
    Route::resource('edit_akses', EditAksesController::class);

    Route::resource('data_pelatihan', DataPelatihanController::class);
    Route::post('/data_pelatihan/import', [DataPelatihanController::class, 'importExcelData']);

    Route::resource('data_pendidikan', DataPendidikanController::class);
    Route::post('/data_pendidikan/import', [DataPendidikanController::class, 'importExcelData']);

    Route::resource('bentuk_jalur', BentukJalurController::class);
    // Tambahkan route filter bentuk jalur berdasarkan kategori
    Route::get('/bentuk_jalur/filter/{kategori}', [BentukJalurController::class, 'filterByKategori']);
    
    Route::resource('kelompok', KelompokController::class);

    
    Route::post('/kelompok/reset', [KelompokController::class, 'reset']);
    
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil');

    
    Route::post('/profil/tambah_foto', [ProfilController::class, 'processFoto']);

    Route::post('/profil/ganti_foto', [ProfilController::class, 'processFoto']);
    
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


