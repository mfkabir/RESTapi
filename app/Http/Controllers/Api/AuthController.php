<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request(['email', 'password']);
            if(!Auth::attempt($credentials)){
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Unauthorize'
                ]);
            }

            $user = Auth::user();
            $token_result = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'status_code' => 200,
                'access_token' => $token_result,
                'token_type' => 'Bearer'
            ]);
        } catch (Exception $err) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $err
            ]);
        }
    }
}
