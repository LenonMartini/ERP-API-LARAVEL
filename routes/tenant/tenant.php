<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TenantController;

Route::middleware('auth:sanctum')->prefix('tenants')->group(function () {
    Route::get('/', [TenantController::class, 'index']);
    Route::get('/{id}', [TenantController::class, 'show']);
    Route::post('/', [TenantController::class, 'store']);
    Route::put('/{id}', [TenantController::class, 'update']);
    Route::delete('/{id}', [TenantController::class, 'destroy']);
});
