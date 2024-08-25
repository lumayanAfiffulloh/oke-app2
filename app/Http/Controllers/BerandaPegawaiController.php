<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaPegawaiController extends Controller
{
    public function index(){
        return view('pegawai.beranda_index');
    }
}
