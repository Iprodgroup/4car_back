<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function response($data): JsonResponse
    {
        return response()->json([
            'data' => $data,
        ]);
    }
    public function success(string $message, $data = null, int $code = null): JsonResponse
    {
        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => $message ?? 'operation successfull',
            'data' => $data,
            'code' => $code,
        ]);

    }


    public function error(string $message, $data = null, int $code = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'status' => 'error',
            'message' => $message ?? 'error occured',
            'data' => $data,
            'code' => $code,
        ]);
    }

}
