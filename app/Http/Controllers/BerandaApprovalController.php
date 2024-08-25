<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaApprovalController extends Controller
{
    public function index(){
        return view('approval.beranda_index');
    }
}
