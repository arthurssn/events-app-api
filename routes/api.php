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
        Route::get('my-registrations', [EventController::class, 'myRegistrations']);
        Route::get('/', [EventController::class, 'index']);
        Route::get('{event}', [EventController::class, 'show']);
        Route::post('{event}/register', [EventController::class, 'register']);
    });

    Route::prefix('event-registrations')->group(function () {
        Route::post('{registration}/cancel', [EventController::class, 'cancelRegistration']);
    });
});
