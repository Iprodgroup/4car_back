<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function showUserData()
    {
        $user = Auth::user();
        return UserResource::collection($user);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request);
        if ($this->authService) {
            return $this->error('Пользователь с таким email уже зарегистрирован!', $user, 400);
        }
        return $this->success('Вы успешно зарегестрировались!', $user, 201);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Неверный логин или пароль'
            ], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['access_token' => $token, 'token_type' => 'Bearer'],200);
    }

    public function logout(Request $request)
    {
        if ($user = $request->user()) {
            $user->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Вы успешно вышли из системы',
            ], 200);
        }

        return response()->json([
            'message' => 'Пользователь не аутентифицирован',
        ], 401);
    }


    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Текущий пароль неверный'
            ], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Пароль успешно изменен'
        ], 200);
    }

    public function user(Request $request)
    {
        return response()->json(new UserResource($request->user()));
    }

}
