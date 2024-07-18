<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\AuthService;
use App\Models\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $result = $this->authService->login($credentials);
        if (isset($result['error'])) {
            return $this->error('Неправильные данные для входа');
        }

        return response()->json([
            'access_token' => $result['access_token'],
            'token_type' => 'Bearer',
        ],$result['status']);

    }

    public function logout()
    {

    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->all());
        return $this->success('User successfully registered', $user);
    }

    public function changePassword()
    {

    }



    public function user(Request $request)
    {
        return $this->response(new UserResource($request->user()));
    }

}
