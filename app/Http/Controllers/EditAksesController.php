<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class EditAksesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('can:admin');
    }

    public function index()
    {
        // Membuat query awal untuk model User
        $query = User::query();
        
        // Memeriksa apakah ada input pencarian ('q')
        $isSearching = request()->filled('q');
        
        if ($isSearching) {
            // Melakukan pencarian berdasarkan nama user
            $query->where('name', 'like', '%' . request('q') . '%');
        }

        // Melakukan paginasi hasil query
        $data['user'] = $query->latest()->paginate(10);

        // Jika pencarian dilakukan dan tidak ada data ditemukan
        if ($isSearching && $data['user']->isEmpty()) {
            flash('Data yang Anda cari tidak ditemukan.')->error();
        }

        // Menampilkan view dengan data user
        return view('edit_akses_index', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'akses' => 'required' // Sesuaikan dengan roles yang ada
        ]);

        // Menggunakan metode update() langsung untuk memperbarui data
        $user->update([
            'akses' => $request->input('akses'),
        ]);
        // $user->fill($userData);
        // $user->save();

        flash('Hak Akses Berhasil Diedit!')->success();
        return redirect()->route('edit_akses.index');
    }
    

}
