<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @tags Authentication
 */
class LoginController extends Controller
{
    /**
     * @unauthenticated
     * @operationId Login
     */
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            /** @example test@example.com */
            'email' => 'required|email',
            /** @example password */
            'password' => 'required',
            /** @example PHPStorm */
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken
        ]);
    }
}
