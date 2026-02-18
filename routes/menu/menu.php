<?php

use App\Http\Controllers\Api\MenuController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])
    ->prefix('menus')
    ->group(function () {
        Route::get('/', [MenuController::class, 'index']);
    });
