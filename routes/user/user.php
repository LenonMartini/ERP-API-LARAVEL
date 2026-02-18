<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'tenant.context'])
    ->group(function () {
        Route::apiResource('users', UserController::class);
    });
