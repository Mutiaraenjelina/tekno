<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-middleware-direct', function () {
    $user = \App\Models\User::where('username', 'super admin')->first();

    if (! $user) {
        return response()->json(['error' => 'User not found']);
    }

    $result = [
        'user' => [
            'id' => $user->id,
            'username' => $user->username,
            'roleId' => $user->roleId,
        ],
        'role_relationship' => [
            'exists' => $user->roles !== null,
            'roleName' => $user->roles?->roleName ?? 'NULL',
        ],
    ];

    \Illuminate\Support\Facades\Auth::login($user);

    $result['after_login'] = [
        'auth_check' => \Illuminate\Support\Facades\Auth::check(),
        'user_id' => \Illuminate\Support\Facades\Auth::id(),
        'user_role' => \Illuminate\Support\Facades\Auth::user()?->roles?->roleName ?? 'NULL',
    ];

    return response()->json($result);
});

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('login', 'App\Http\Controllers\auth\AuthController@index')->name('login');
Route::get('register', 'App\Http\Controllers\auth\AuthController@register')->name('register');
Route::post('proses_register', 'App\Http\Controllers\auth\AuthController@proses_register')->name('proses_register');
Route::post('proses_login', 'App\Http\Controllers\auth\AuthController@proses_login')->name('proses_login');
Route::get('logout', 'App\Http\Controllers\auth\AuthController@logout')->name('logout');

Route::middleware(['auth'])->group(function () {
    // User Dashboard Route
    Route::get('/dashboard', [App\Http\Controllers\user\DashboardController::class, 'index'])->name('user.dashboard.index');

    // User Tagihan JSON Route (for dashboard)
    Route::get('/user/tagihan/data', [App\Http\Controllers\user\TagihanController::class, 'data'])->name('api.user.tagihan.index');

    // User Tagihan Routes
    Route::get('/tagihan', [App\Http\Controllers\user\TagihanController::class, 'index'])->name('user.tagihan.index');
    Route::get('/tagihan/status', [App\Http\Controllers\user\TagihanController::class, 'status'])->name('user.tagihan.status');
    Route::get('/assignment-tagihan-user', [App\Http\Controllers\user\TagihanController::class, 'status'])->name('user.assignment.tagihan.index');
    Route::get('/tagihan/{tagihanId}', [App\Http\Controllers\user\TagihanController::class, 'show'])->name('user.tagihan.show');

    // User Pelanggan Profile Route
    Route::get('/profil/pelanggan', [App\Http\Controllers\user\PelangganController::class, 'index'])->name('user.pelanggan.index');

    // Payment Page Routes
    Route::get('/payment/{tagihanId}/{userId}', [App\Http\Controllers\PaymentPageController::class, 'show'])->name('PaymentPage.show');
    Route::post('/payment/{tagihanId}/{userId}/create', [App\Http\Controllers\PaymentPageController::class, 'create'])->name('PaymentPage.create');
});
