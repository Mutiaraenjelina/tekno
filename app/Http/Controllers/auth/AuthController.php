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
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function proses_register(Request $request)
    {
        $validated = $request->validate([
            'jenis_tagihan' => ['required', 'in:rutin,non_rutin'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'nama' => ['required_if:jenis_tagihan,rutin', 'nullable', 'string', 'max:255'],
            'no_wa' => ['required_if:jenis_tagihan,rutin', 'nullable', 'string', 'max:30'],
        ], [
            'jenis_tagihan.required' => 'Silakan pilih jenis tagihan usaha.',
            'jenis_tagihan.in' => 'Jenis tagihan tidak valid.',
            'nama.required_if' => 'Nama pelanggan wajib diisi untuk usaha tagihan rutin.',
            'no_wa.required_if' => 'No WhatsApp wajib diisi untuk usaha tagihan rutin.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        DB::beginTransaction();

        try {
            $namaPelanggan = $validated['jenis_tagihan'] === 'rutin'
                ? $validated['nama']
                : $validated['username'];

            $noWaPelanggan = $validated['jenis_tagihan'] === 'rutin'
                ? $validated['no_wa']
                : '-';

            // users.idPersonal pada schema aktif wajib terisi.
            $pelangganId = DB::table('pelanggan')->insertGetId([
                'nama' => $namaPelanggan,
                'no_wa' => $noWaPelanggan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            User::create([
                'roleId' => 3,
                'idJenisUser' => $validated['jenis_tagihan'] === 'rutin' ? 1 : 2,
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

            //dd($userRole);

            if ($user->roleId == '1') {
                //dd($userRole);
                \Log::info('Redirecting Super Admin to Dashboard.index');
                return redirect()->route('Dashboard.index'); 
            }elseif ($user->roleId == '2') {
                \Log::info('Redirecting Admin to Dashboard.index');
                //return redirect()->intended('admin');
                return redirect()->route('Dashboard.index');
            }elseif ($user->roleId == '3') {
                \Log::info('Redirecting User to user.dashboard.index');
                return redirect()->route('user.dashboard.index');
            } 
            

            \Log::info('No role match, redirecting to /');
            return redirect()->intended('/');
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
}
