<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\AuthController;

Route::prefix('auth')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [MeController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/roles-permissions', [MeController::class, 'rolesPermissions']);
    });
});
