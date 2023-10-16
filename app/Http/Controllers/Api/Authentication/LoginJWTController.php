<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @tags Authentication
 */
class LoginJWTController extends Controller
{
    /**
     * @unauthenticated
     * @operationId Login
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            /** @example test@example.com */
            'email' => 'required|email',
            /** @example password */
            'password' => 'required',
        ]);

        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
