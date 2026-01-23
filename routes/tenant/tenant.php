<?php

use App\Http\Controllers\Api\TenantController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'system'])
    ->prefix('tenants')
    ->group(function () {
        Route::get('/', [TenantController::class, 'index']);
        Route::get('/{tenant}', [TenantController::class, 'show']);
        Route::post('/', [TenantController::class, 'store']);
        Route::put('/{tenant}', [TenantController::class, 'update']);
        Route::delete('/{tenant}', [TenantController::class, 'destroy']);
    });
