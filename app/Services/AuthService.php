<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{

    public function __construct(
        private UserService $userService
    ) {}

    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return null; // Retorna null si las credenciales son inválidas
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }

    public function register(array $data)
    {
        // Crear el usuario
        $user = $this->userService->createUser($data);

        // Enviar correo de verificación
        $user->sendEmailVerificationNotification();

        // Generar token para el usuario
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }
}
