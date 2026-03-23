<?php

use Illuminate\Support\Facades\Route;
use Arkadip\EmailChannel\Http\Controllers\EmailController;

Route::prefix('email-channel')->group(function () {

    // ✅ View dashboard (optional UI)
    Route::get('/dashboard', function () {
        return view('email-channel::dashboard');
    });

    // ✅ Get latest emails
    Route::get('/emails', [EmailController::class, 'index']);

    // ✅ Send email
    Route::post('/send', [EmailController::class, 'send']);

    // ✅ Fetch new emails (manual trigger if needed)
    Route::post('/fetch', [EmailController::class, 'fetch']);
});