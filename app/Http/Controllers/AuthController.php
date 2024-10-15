<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;

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

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'));

        return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Ссылка для сброса пароля отправлена на ваш email.'], 200)
            : response()->json(['error' => 'Не удалось отправить ссылку для сброса пароля'], 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $response == Password::PASSWORD_RESET
            ? response()->json(['message' => 'Пароль успешно сброшен.'], 200)
            : response()->json(['error' => 'Не удалось сбросить пароль'], 400);
    }

}
