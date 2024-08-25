<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaKetuaKelompokController extends Controller
{
    public function index(){
        return view('ketua_kelompok.beranda_index');
    }
}
