<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\DataPegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
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

    protected function sendFailedLoginResponse()
    {
        throw ValidationException::withMessages([
            'login' => [trans('auth.failed')],
        ]);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function username()
    {
        $login = request()->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email': 'name';
        request()->merge([$field=>$login]);
        return $field;


        // // Cek apakah input adalah email
        // if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        //     return 'email';
        // }

        // // Jika input bukan email, asumsikan itu adalah nip
        // $pegawai = DataPegawai::where('nip', $login)->first();

        // if ($pegawai && $pegawai->user) {
        //     // Temukan user yang terkait dengan pegawai tersebut melalui user_id
        //     request()->merge(['email' => $pegawai->user->email]);
        //     return 'email';
        // }

        // // Jika nip tidak ditemukan, kembalikan 'email' untuk validasi gagal
        // return 'email';
    }

    /**
     * Create a new controller instance.
     *
     * @return RedirectResponse
     */
    public function authenticated(Request $request, $user): RedirectResponse
    {   
        
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
        $this->validateLogin($request);
        

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        // Set flash message
        session()->flash('status', 'Selamat datang di aplikasi SANTI!');

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }
}
