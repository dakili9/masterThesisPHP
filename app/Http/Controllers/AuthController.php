<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class AuthController extends Controller
{
    /**
     * Handles user login.
     *
     * @param AuthLoginRequest $request
     * @return JsonResponse
     */
    public function login(AuthLoginRequest $request): JsonResponse
    {
        $reqData = $request->only(['email',
            'password'
            ]);

        $user = User::where('email', $reqData['email'])->first();

        if(!$user || !Hash::check($reqData['password'], $user->password)) {
            return response()->json(['The provided credentials are incorrect.'], 401);
        }

        $token = $user->createToken($reqData['email'])->plainTextToken;

        return response()->json(
            [
                'user' => $user,
                'token' => $token
            ]
        );
    }

    /**
     * Handles user registration.
     *
     * @param AuthRegisterRequest $request
     * @return JsonResponse
     */
    public function register(AuthRegisterRequest $request): JsonResponse
    {
        $reqData = $request->only([
            'name',
            'email',
            'password'
        ]);

        $user = User::create(array_merge(
            ['id' => (string) Str::uuid()],
            $reqData
        ));

        $token = $user->createToken($reqData['name'])->plainTextToken;

        return response()->json(
            [
                'user' => $user,
                'token' => $token
            ]
        );
    }

    /**
     * Handles user logout.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json(['The user is logged out.']);
    }
}
