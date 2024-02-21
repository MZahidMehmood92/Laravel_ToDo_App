<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
{
    $validator = Validator::make($request->all(),
    [
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed',
    ]);

    if ($validator->fails())
     {
        return response()->json(['errors' => $validator->errors()], 422);
     }

    $token = random_int(1000000, 9999999);

    User::create
    ([
        'email' => $request->email,
        'password' => $request->password,
        'verification_code' => $token
    ]);
     return response()->json(['message' => 'User registered successfully. Please verify your email.'], 201);
}


public function verify($code)
{

    $user = User::where('verification_code', $code)->first();
    if (!$user) {
        return response()->json(['error' => 'Invalid verification code.'], 404);
    }

    $user->email_verified_at = Carbon::now();
    $user->save();

    return response()->json(['message' => 'User verified successfully.'], 200);
}



public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return response()->json(['error' => 'Invalid credentials.'], 401);
    }

    $user = Auth::user();

    if (!$user->email_verified_at) {
        return response()->json(['error' => 'User not verified.'], 403);
    }

    $token = $user->createToken('AuthToken')->plainTextToken;

    return response()->json(['token' => $token], 200);
}


public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'User logged out successfully.'], 200);
}


}
