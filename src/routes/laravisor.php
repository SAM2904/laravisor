<?php

use Illuminate\Support\Facades\Route;
use Sam\Laravisor\Http\Controllers\LaravisorErrorController;

Route::middleware('laravisor.viewer')->group(function () {
    Route::get('/laravisor/error-logs', [LaravisorErrorController::class, 'index']);
    Route::get('/laravisor/error-logs/{errorId}', [LaravisorErrorController::class, 'show']);
});
