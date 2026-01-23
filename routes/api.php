<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/auth/auth.php';
require __DIR__.'/tenant/tenant.php';
require __DIR__.'/preference/preference.php';
require __DIR__.'/user/user.php';

Route::get('ping', function () {
    return response()->json(['message' => 'pong'], 200);
});
