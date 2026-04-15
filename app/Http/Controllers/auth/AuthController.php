<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return view('auth.login');
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
                \Log::info('Redirecting User to WajibRetribusi.dashboardUser');
                return redirect()->route('WajibRetribusi.dashboardUser');
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
