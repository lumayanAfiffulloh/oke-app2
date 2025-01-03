<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\User;
use App\Models\DataPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
	public function processFoto(Request $request)
	{
		$dataPegawai = Auth::user()->dataPegawai;

		$request->validate([
			'foto' => 'required|image|mimes:jpeg,png,jpg|max:5000',
		]);

		if ($request->hasFile('foto')) {
			// Hapus foto lama jika ada
			if ($dataPegawai->foto && Storage::exists($dataPegawai->foto)) {
					Storage::delete($dataPegawai->foto);
			}

			// Simpan foto baru
			$dataPegawai->foto = $request->file('foto')->store('public/foto');
		}

		$dataPegawai->save();

		flash('Foto profil berhasil diperbarui!')->success();
		return redirect()->route('profil');
	}


	/**
	 * Remove the specified resource from storage.
	 */
	public function changePassword()
	{
		// Hapus session default_password
    session()->forget('default_password');

		return view('password_edit');
	}

	public function processPassword(Request $request)
	{
		$request->validate([
			'password_sekarang' => 'required',
			'password_baru' => 'required',
			'konfirmasi_password' => 'required',
		]);

		$user= Auth::user();

		if(!Hash::check($request->password_sekarang, $user->password)){
			return back()->withErrors([
				'password_sekarang' => 'Password tidak sesuai',
			]);
		}

		if($request->password_baru != $request->konfirmasi_password){
			return back()->withErrors([
				'konfirmasi_password' => 'Konfirmasi password tidak cocok dengan password baru.',
			]);
		}
		
		User::whereId(Auth::user()->id)->update([
			'password' => Hash::make($request->password_baru)
		]);

		flash('Password berhasil diubah!')->success();
    return redirect()->route('profil');
	}
}
