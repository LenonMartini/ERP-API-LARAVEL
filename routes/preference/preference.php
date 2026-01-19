<?php

use App\Http\Controllers\Api\UserPrefereController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    Route::middleware('auth:api')->prefix('preferences')->group(function () {

        Route::put('/{id}', [UserPrefereController::class, 'update']);
    });
});
