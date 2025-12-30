<?php


use Illuminate\Support\Facades\Route;

require __DIR__.'/auth/auth.php';
require __DIR__.'/tenant/tenant.php';



Route::get('ping', function () {
    return response()->json(['message' => 'pong'], 200);
});
