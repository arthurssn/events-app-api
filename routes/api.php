<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Events\EventController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::prefix('events')->group(function () {
        Route::get('my-registrations', [EventController::class, 'myRegistrations']); // Minhas inscrições (primeira rota)
        Route::get('/', [EventController::class, 'index']); // Listar eventos
        Route::get('{event}', [EventController::class, 'show']); // Detalhar evento
        Route::post('{event}/register', [EventController::class, 'register']); // Inscrever em evento
    });

    Route::prefix('event-registrations')->group(function () {
        Route::post('{registration}/cancel', [EventController::class, 'cancelRegistration']); // Cancelar inscrição
    });
});
