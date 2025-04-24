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

    Route::get('/events/my-registrations', [EventController::class, 'myRegistrations']);
    Route::post('/events/{id}/cancel', [EventController::class, 'cancelRegistration']);
    Route::get('events', [EventController::class, 'index']);
    Route::get('events/{event}', [EventController::class, 'show']);
    Route::post('/events/{event}/register', [EventController::class, 'register']);
});
