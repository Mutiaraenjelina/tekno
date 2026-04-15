<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckJwtAndClientId
{
    private $validClientIds = ['F8cZWWw09A7qM9ZrxFF7DqFSev5RB7cq', 'WkmMz40xlhO3GyQmE5Rit0LV1YerExnI', 'sbW8wFxooiscejbJNGByXRvOarFgY3RV', 'OXCfNLPizc8Cbe3aTn6JrRR2n9VV2Gep', '2kadMK7vwBQp9tDEd2OqvSxuPYimFQoK'];

    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $vendorId = $request->header('Vendor-ID');

        if (!$vendorId || !in_array($vendorId, $this->validClientIds)) {
            return response()->json(['error' => 'Forbidden: Invalid Client ID'], 403);
        }

        return $next($request);
    }
}
