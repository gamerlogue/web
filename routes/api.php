<?php

declare(strict_types=1);

use App\Http\Controllers\IgdbProxyController;
use App\Http\Controllers\SanctumTokenController;
use Illuminate\Support\Facades\Route;

Route::post('/sanctum/token/exchange', [SanctumTokenController::class, 'exchange'])
    ->middleware('throttle:10,1');

/**
 * IGDB proxy: forwards to https://api.igdb.com/v4/{path}
 */
Route::middleware(['auth:sanctum', 'throttle:igdb'])
    ->post('/igdb/{path}', [IgdbProxyController::class, 'handle'])
    ->name('igdb.proxy');
