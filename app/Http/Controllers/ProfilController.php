<?php

namespace App\Http\Controllers;

use App\Models\DataPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
			//
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
			//
	}

	/**
	 * Display the specified resource.
	 */
	public function show()
	{
		// Ambil user yang sedang login
		$user = Auth::user();

		// Ambil data pegawai terkait user
		$dataPegawai = $user->dataPegawai;

		// Ambil pelatihan yang terkait dengan pegawai dan grupkan berdasarkan tahun
    if ($dataPegawai) {
			$rencanaPembelajaran = $dataPegawai->rencanaPembelajaran()
					->selectRaw('tahun, SUM(jam_pelajaran) as total_jam_pelajaran')
					->groupBy('tahun')
					->orderBy('tahun', 'asc')
					->get();
		} else {
				$rencanaPembelajaran = null;
		}

		return view('profil', compact('user', 'dataPegawai', 'rencanaPembelajaran'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(DataPegawai $dataPegawai)
	{
			//
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, DataPegawai $dataPegawai)
	{
			//
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(DataPegawai $dataPegawai)
	{
			//
	}
}
