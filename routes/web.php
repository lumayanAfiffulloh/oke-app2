<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PelaksanaanPembelajaranController;
use App\Http\Controllers\CitamController;

Route::resource('pegawai', PegawaiController::class);
Route::resource('citam', CitamController::class);

Route::get('/pelaksanaan_pembelajaran', [PelaksanaanPembelajaranController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});
