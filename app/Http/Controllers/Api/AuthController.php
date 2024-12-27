<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            auth()->user()->update(['device_token' => $request->device_token]);
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            $userAbilities = $user->getAllPermissions()->pluck('name');
            $userRoles = $user->getRoleNames();

            $userData = Auth::user();
            $userData->role = $userRoles;

            return response()->json([
                'status' => 200,
                'accessToken' => $token,
                'token_type' => 'Bearer',
                'userAbilities' => $userAbilities,
                'userData' => $userData
            ], 200);
            // return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
        }

        return response()->json(['status' => 401, 'error' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['status' => 200, 'message' => 'Logged out'], 200);
    }
}
