<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //dd($credentials);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'responseCode' => 200,
            'responseMessage' => "Successful",
            'accessToken' => $token,
            'tokenType' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 15
        ]);
    }
}
