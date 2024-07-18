<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),

        ]);
    }

    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return ['error' => 'Invalid login details', 'status' => 401];
        }
        $user = User::where('email', $credentials['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return ['access_token' => $token, 'token_type' => 'Bearer', 'status' => 200];
    }

}
