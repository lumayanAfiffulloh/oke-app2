<?php

use App\Http\Controllers\BerandaAdminController;
use App\Http\Controllers\BerandaApprovalController;
use App\Http\Controllers\BerandaKetuaKelompokController;
use App\Http\Controllers\BerandaPegawaiController;
use App\Http\Controllers\BerandaVerifikatorController;
use App\Http\Controllers\DataPegawaiController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PelaksanaanPembelajaranController;
use App\Http\Controllers\RencanaPembelajaranController;
use Illuminate\Auth\Middleware\Authenticate;

Route::prefix('pegawai')->middleware(['auth', 'pegawai-access'])->group(function () {  
    Route::get('beranda', [BerandaPegawaiController::class, 'index'])->name('pegawai.beranda');
});

Route::prefix('ketua_kelompok')->middleware(['auth', 'ketua_kelompok-access'])->group(function () {  
    Route::get('beranda', [BerandaKetuaKelompokController::class, 'index'])->name('ketua_kelompok.beranda');
});

Route::prefix('verifikator')->middleware(['auth', 'verifikator-access'])->group(function () {  
    Route::get('beranda', [BerandaVerifikatorController::class, 'index'])->name('verifikator.beranda');
});

Route::prefix('approval')->middleware(['auth', 'approval-access'])->group(function () {  
    Route::get('beranda', [BerandaApprovalController::class, 'index'])->name('approval.beranda');
});

Route::prefix('admin')->middleware(['auth', 'admin-access'])->group(function () {  
    Route::get('beranda', [BerandaAdminController::class, 'index'])->name('admin.beranda');
});



Route::middleware([Authenticate::class])->group(function () {
    
    Route::resource('data_pegawai', DataPegawaiController::class);

    Route::resource('pelaksanaan_pembelajaran', PelaksanaanPembelajaranController::class);

    Route::resource('rencana_pembelajaran', RencanaPembelajaranController::class);

    
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('logout', function () {
    Auth::logout();
    return redirect('login');

});



Auth::routes(); 
