<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
            'login'    => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Email/NIP/NPPU wajib diisi.',
        ]);
    }

    public function login(Request $request)
    {
        // Validasi input
        $this->validateLogin($request);

        // Tentukan apakah input adalah email atau NIP
        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nppu';

        // Jika login menggunakan nppu, cari di tabel pegawai
        if ($field === 'nppu') {
            $pegawai = \App\Models\DataPegawai::where('nppu', $login)->first();

            if (! $pegawai) {
                return back()->withErrors([
                    'login' => 'NIP/NPPU tidak ditemukan.',
                ]);
            }

                                    // Ambil email atau username dari tabel users
            $user = $pegawai->user; // Mengambil data user terkait
                                    // Cek apakah user terkait ada
            if (! $user) {
                return back()->withErrors([
                    'login' => 'User terkait dengan NIP/NPPU tidak ditemukan.',
                ]);
            }
            // Buat kredensial untuk autentikasi
            $credentials = ['email' => $user->email, 'password' => $request->input('password')];
        } else {
            // Jika menggunakan email, langsung gunakan data dari request
            $credentials = ['email' => $request->input('login'), 'password' => $request->input('password')];
        }

        // Autentikasi pengguna
        if (Auth::attempt($credentials)) {
            return $this->sendLoginResponse($request);
        }

        return back()->withErrors([
            'login' => 'Login gagal. Silakan periksa NIP/Email dan password.',
        ]);
    }

    /**
     * Create a new controller instance.
     *
     * @return RedirectResponse
     */

    protected function sendLoginResponse(Request $request)
    {
        $this->validateLogin($request);
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);

        return redirect()->intended('/profil')
            ->with('status', 'Selamat datang di aplikasi SANTI!');
    }

}
