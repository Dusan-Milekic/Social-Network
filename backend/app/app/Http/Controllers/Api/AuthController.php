<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
    $validated = $request->validate([
        'name' => 'required|string',
        'last_name' => 'required|string',
        'username' => 'required|string|unique:users,username',
        'email' => 'required|string|email|unique:users,email',
        'password' => 'required|string|min:6'
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'last_name' => $validated['last_name'],
        'username' => $validated['username'],
        'email' => $validated['email'],
        'password' => $validated['password'], // automatski se hash-uje jer imaš 'password' => 'hashed'
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'User registered successfully',
        'user' => $user
    ], 201);
    }

}
