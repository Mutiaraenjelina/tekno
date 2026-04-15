<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Cek_login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles): Response
    {
        \Log::info('Cek_login middleware called', ['path' => $request->path(), 'roles' => $roles]);
        
        if (!Auth::check()) {
            \Log::info('Auth::check() returned false, redirecting to login');
            return redirect('login');
        }

        \Log::info('User authenticated', ['user_id' => Auth::id()]);

        try {
            $user = Auth::user();
            \Log::info('Got user from Auth', ['user_id' => $user->id, 'username' => $user->username]);
            
            $userRole = $user->role_name;
            
            \Log::info('Got user role', ['userRole' => $userRole, 'roleId' => $user->roleId]);
            
            if (!$userRole) {
                // Log error but don't crash
                \Log::error('User role not found for user: ' . $user->id);
                return redirect('/login')->with('error', 'User role not configured');
            }
            
            // Split roles parameter by pipe and trim whitespace
            $allowedRoles = array_map('trim', explode('|', $roles));
            \Log::info('Allowed roles', ['allowedRoles' => $allowedRoles]);

            if (in_array($userRole, $allowedRoles)) {
                \Log::info('Role check passed, allowing request');
                return $next($request);
            }

            \Log::info('Role check failed', ['userRole' => $userRole, 'allowedRoles' => $allowedRoles, 'in_array' => false]);

            // User does not have access - redirect to their appropriate dashboard
            // IMPORTANT: Never redirect back to the same protected route (infinite loop)
            if (in_array($userRole, ['Super Admin', 'Admin'])) {
                // Admin users go to home page
                \Log::info('Admin denied access, redirecting to /');
                return redirect('/')->with('error', "Anda Tidak Punya Akses Untuk Area Ini");
            }
            
            \Log::info('User denied access, redirecting to /dashboard');
            return redirect('/dashboard')->with('error', "Anda Tidak Punya Akses Untuk Area Ini");
            
        } catch (\Exception $e) {
            \Log::error('Cek_login middleware error: ' . $e->getMessage(), ['exception' => $e]);
            return redirect('/login')->with('error', 'Authentication error');
        }
    }
}
