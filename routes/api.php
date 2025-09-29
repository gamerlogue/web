<?php

/**
 * IGDB proxy routes
 * Redirects to https://api.igdb.com/v4/{percorso}
 */

use App\Http\Controllers\IgdbProxyController;

Route::middleware(['throttle:igdb'])
    ->post('/igdb/{path}', [IgdbProxyController::class, 'handle'])
    ->name('igdb.proxy');
