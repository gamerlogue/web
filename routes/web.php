<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\IgdbProxyController;
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

/**
 * IGDB proxy routes
 * Supporta tutti i metodi principali e inoltra a https://api.igdb.com/v4/{percorso}
 */
Route::middleware(['throttle:igdb'])
    ->match(['get','post','put','patch','delete','options'], '/igdb/{path?}', [IgdbProxyController::class, 'handle'])
    ->where('path', '.*')
    ->name('igdb.proxy');
