<?php

Route::get('/test-middleware-direct', function() {
    $user = \App\Models\User::where('username', 'super admin')->first();
    
    if (!$user) {
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
        ]
    ];
    
    \Illuminate\Support\Facades\Auth::login($user);
    
    $result['after_login'] = [
        'auth_check' => \Illuminate\Support\Facades\Auth::check(),
        'user_id' => \Illuminate\Support\Facades\Auth::id(),
        'user_role' => \Illuminate\Support\Facades\Auth::user()?->roles?->roleName ?? 'NULL',
    ];
    
    // Test middleware logic
    $userRole = \Illuminate\Support\Facades\Auth::user()->roles ? \Illuminate\Support\Facades\Auth::user()->roles->roleName : null;
    $roles = "Admin, Super Admin";
    $allowedRoles = array_map('trim', explode(',', $roles));
    
    $result['middleware_check'] = [
        'userRole' => $userRole,
        'allowedRoles' => $allowedRoles,
        'in_array_result' => in_array($userRole, $allowedRoles),
    ];
    
    return response()->json($result);
});
