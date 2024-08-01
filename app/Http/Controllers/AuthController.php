<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 0    //Default role "student"
        ]);

        return response()->json([
            "message" => "User registered successfully.",
            "token" => $user->createToken('token')->plainTextToken,
            "user" => $user
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        if(!Auth::attempt($data)){
            return response()->json([
                "email" => "The email or password is incorrect."
            ], 422);
        }

        $user = Auth::user();

        return response()->json([
            "message" => "User logged in successfully.",
            "token" => $user->createToken('token')->plainTextToken,
            "user" => $user
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response()->json([
            "message" => "User logged out successfully.",
            "user" => null
        ]);
    }
}
