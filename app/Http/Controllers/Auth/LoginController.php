<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Create a new controller instance.
     *
     * @return RedirectResponse
     */
    public function authenticated(Request $request, $user): RedirectResponse
    {   
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if ($user->akses == 'pegawai') {
            return redirect()->route('pegawai.beranda');
        }else if ($user->akses == 'ketua_kelompok') {
            return redirect()->route('ketua_kelompok.beranda');
        }else if ($user->akses == 'verifikator') {
            return redirect()->route('verifikator.beranda');
        }else if ($user->akses == 'approval') {
            return redirect()->route('approval.beranda');
        }else if ($user->akses == 'admin') {
            return redirect()->route('admin.beranda');
        };
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        // Set flash message
        session()->flash('status', 'Selamat datang di aplikasi SINTA!');

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }
}
