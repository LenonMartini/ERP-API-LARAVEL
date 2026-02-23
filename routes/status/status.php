<?php

use App\Http\Controllers\Api\StatusController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'tenant.context'])
    ->group(function () {
        Route::apiResource('status', StatusController::class);
    });
