<?php

namespace App\Services;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $existingUser = User::where('email', $data['email'])->first();

        if ($existingUser) {
            return false;
        }

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
            return response()->json(
                ['error' => 'Invalid login details'],
                401);
        }
        $user = User::where('email', $credentials['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer'],200);
    }

}
