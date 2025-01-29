<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\UserLoginRequest;
use App\Http\Requests\Core\UserRequest;
use App\Services\Core\AuthService;
use Illuminate\Http\JsonResponse;
use Exception;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ){}

    public function register(UserRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());

        return response()->json([
            'message' => 'Usuário registrado com sucesso!',
            'user' => $user
        ], 201);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        try {
            $token = $this->authService->login($request->validated());

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();
        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    public function me(): JsonResponse
    {
        return response()->json($this->authService->me());
    }
}
