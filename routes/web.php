<?php

use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return "OK";
//    return redirect()
//        // Resend the session data to the frontend to avoid losing it
//        ->with(request()->session()->all());
});

/**
 * Service routes
 */
Route::patch('/set-locale', [LocaleController::class, 'update'])->name('set-locale');
