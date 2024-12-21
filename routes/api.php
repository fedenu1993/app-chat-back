<?php

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Se puede volver a enviar verificacion o verificar la cuenta solo si estas logueado
Route::middleware('auth:sanctum')->group(function () {
    // Enviar el enlace de verificación
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification link sent!']);
    })->name('verification.send');

    // Verificar el correo electrónico
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return response()->json(['message' => 'Email verified!']);
    })->name('verification.verify');
});

// Solo cuentas verificadas pueden acceder a estos endpoint
// El verified permite acceso solo a usuario verificados (confirmaron el mail)
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Endpoints para chat

    // Endpoints para pagos


});