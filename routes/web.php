<?php

use App\Http\Controllers\DataPegawaiController;
use App\Http\Controllers\DataPelatihanController;
use App\Http\Controllers\KelompokController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelaksanaanPembelajaranController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RencanaPembelajaranController;
use Illuminate\Auth\Middleware\Authenticate;


Route::middleware([Authenticate::class])->group(function () {
    
    Route::resource('data_pegawai', DataPegawaiController::class);

    Route::resource('rencana_pembelajaran', RencanaPembelajaranController::class);

    Route::resource('data_pelatihan', DataPelatihanController::class);

    Route::resource('kelompok', KelompokController::class);
    
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil');
});

Route::get('/', function () {
    // Jika pengguna sudah login, arahkan ke /profil
    if (Auth::check()) {
        return redirect('profil');
    }
    return view('welcome');
});


Auth::routes(); 
