<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller
{

    public function __construct(private AuthService $authService) {}

    public function login(LoginRequest $request)
    {
        // Obtener las credenciales del request
        $credentials = $request->validated();

        // Delegar la lógica de login al servicio
        $response = $this->authService->login($credentials);

        if (!$response) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'token' => $response['token'],
            'user' => $response['user'],
        ]);
    }

    public function register(RegisterRequest $request)
    {
        // Validar los datos
        $validatedData = $request->validated();

        // Delegar la lógica de registro al servicio
        $response = $this->authService->register($validatedData);

        return response()->json([
            'access_token' => $response['token'],
            'token_type' => 'Bearer',
            'user' => $response['user'],
        ]);
    }
}
