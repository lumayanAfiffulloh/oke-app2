<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PelaksanaanPembelajaranController;
use App\Http\Controllers\RencanaPembelajaranController;
use Illuminate\Auth\Middleware\Authenticate;



Route::middleware([Authenticate::class])->group(function () {
    Route::resource('pegawai', PegawaiController::class);

    Route::resource('pelaksanaan_pembelajaran', PelaksanaanPembelajaranController::class);

    Route::resource('rencana_pembelajaran', RencanaPembelajaranController::class);

    Route::get('/', function () {
        return view('welcome');
    });
    
});

Route::get('logout', function () {
    Auth::logout();
    return redirect('login');

});

Auth::routes(); 
