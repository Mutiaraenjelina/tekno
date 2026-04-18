<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        if (Auth::check()) {
            return redirect()->route($this->redirectRouteForUser(Auth::user()));
        }

        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function proses_register(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nama_usaha' => ['required', 'string', 'max:255'],
            'no_telepon' => ['required', 'string', 'max:30'],
            'jenis_usaha' => ['required', 'string', 'max:100'],
            'jenis_tagihan' => ['required', 'in:rutin,non-rutin'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_usaha.required' => 'Nama usaha wajib diisi.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'jenis_usaha.required' => 'Jenis usaha wajib dipilih.',
            'jenis_tagihan.required' => 'Jenis tagihan wajib dipilih.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        DB::beginTransaction();

        try {
            // users.idPersonal pada schema aktif wajib terisi.
            $pelangganId = DB::table('pelanggan')->insertGetId([
                'nama' => $validated['nama_lengkap'],
                'no_wa' => $validated['no_telepon'],
                'nama_usaha' => $validated['nama_usaha'],
                'jenis_usaha' => $validated['jenis_usaha'],
                'jenis_tagihan' => $validated['jenis_tagihan'],
                'is_umkm_verified' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            User::create([
                'roleId' => 2,
                'idJenisUser' => 1,
                'idPersonal' => $pelangganId,
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            DB::commit();

            return redirect()->route('login')->with('success_register', 'Registrasi berhasil. Silakan login.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withInput()->withErrors([
                'register_gagal' => 'Registrasi gagal. Silakan coba lagi.',
            ]);
        }
    }

    public function proses_login(Request $request)
    {
        request()->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ]
        );

        $kredensil = $request->only('username', 'password');

        \Log::info('Login attempt', ['username' => $kredensil['username']]);

        if (Auth::attempt($kredensil)) {
            \Log::info('Auth::attempt succeeded');

            $request->session()->regenerate();
            
            $user = Auth::user();
            \Log::info('Got user', ['user_id' => $user->id, 'username' => $user->username]);
            
            $userRole = $user->role_name;
            \Log::info('Got user role', ['role' => $userRole]);

            // TODO: Create stored procedure view_userSessionById or replace with direct query
            // $userData = DB::select('CALL view_userSessionById(?, ?)', [$user->id, $user->idJenisUser]);
            // $request->session()->put('userSession', $userData);

            // Temporary session data
            $request->session()->put('user_id', $user->id);
            $request->session()->put('user_role', $userRole);
            \Log::info('Session data stored', ['session_id' => $request->session()->getId()]);

            return redirect()->route('login.redirect');
        }

        \Log::info('Auth::attempt failed');
        return redirect('login')
            ->withInput()
            ->withErrors(['login_gagal' => 'Username atau Password Anda Salah!']);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout(); // user must logout before redirect them
        return redirect()->guest('login');
    }

    public function redirectAfterLogin()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $redirectRoute = $this->redirectRouteForUser($user);

        return view('auth.login-redirect', [
            'user' => $user,
            'redirectRoute' => $redirectRoute,
            'redirectUrl' => route($redirectRoute),
        ]);
    }

    private function redirectRouteForUser(User $user): string
    {
        return match ((string) $user->roleId) {
            '1', '2' => 'Dashboard.index',
            '3' => 'user.dashboard.index',
            default => 'logout',
        };
    }
}
