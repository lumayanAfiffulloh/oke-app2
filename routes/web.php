<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PelaksanaanPembelajaranController;

Route::resource('pegawai', PegawaiController::class);

Route::get('/pelaksanaan_pembelajaran', [PelaksanaanPembelajaranController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});
