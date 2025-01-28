<?php

namespace App\Http\Controllers;
use App\Models\Role;
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
        $users = User::with('roles')->latest()->get(); // Ambil semua user dengan relasi roles
        $roles = Role::all(); // Ambil semua role

        // Menampilkan view dengan data user dan roles
        return view('edit_akses_index', compact('users', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Validasi input roles
        $request->validate([
            'roles' => 'required|array', // Roles harus berupa array
            'roles.*' => 'exists:roles,id', // Setiap role harus valid berdasarkan id
        ]);

        // Sinkronisasi roles ke user
        $user->roles()->sync($request->input('roles'));

        flash('Hak Akses Berhasil Diedit!')->success();
        return redirect()->route('edit_akses.index');
    }

    

}
