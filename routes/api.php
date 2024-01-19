<?php

use App\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('forceAcceptJson')->group(function () {
    Route::apiResource('users', UserApiController::class);
});