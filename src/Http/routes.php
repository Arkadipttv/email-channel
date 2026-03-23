<?php

use Illuminate\Support\Facades\Route;
use Arkadip\EmailChannel\Http\Controllers\EmailController;

Route::prefix('email-channel')->group(function () {
    Route::get('/emails', [EmailController::class, 'index']);
    Route::post('/send', [EmailController::class, 'send']);
});