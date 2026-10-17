<?php

declare(strict_types=1);

use App\Http\Controllers\AccountController;
use App\Http\Controllers\IgdbProxyController;
use App\Http\Controllers\ProfileStatsController;
use App\Http\Controllers\ReadAllNotificationsController;
use App\Http\Controllers\ReorderListController;
use App\Http\Controllers\SanctumTokenController;
use Illuminate\Support\Facades\Route;

Route::post('/sanctum/token/exchange', [SanctumTokenController::class, 'exchange'])
    ->middleware('throttle:10,1,sanctum-exchange:');

// Unauthenticated and holding a bearer-equivalent secret: the endpoint an attacker with a stolen
// refresh token would hammer.
Route::post('/sanctum/token/refresh', [SanctumTokenController::class, 'refresh'])
    ->middleware('throttle:30,1,sanctum-refresh:');

// Without this a native sign-out only forgets the tokens locally: the family stays live, and a
// refresh token lifted off a dismissed device keeps working until the family's cap.
Route::post('/sanctum/token/revoke', [SanctumTokenController::class, 'revoke'])
    ->middleware('throttle:30,1,sanctum-revoke:');

/**
 * IGDB proxy: forwards to https://api.igdb.com/v4/{path}, guests included.
 * The endpoint pattern keeps the path a single IGDB endpoint name.
 */
Route::middleware('throttle:igdb')
    ->post('/igdb/{path}', [IgdbProxyController::class, 'handle'])
    ->where('path', '[a-z_]+(\.pb)?')
    ->name('igdb.proxy');

Route::get('/users/{user}/stats', ProfileStatsController::class)->middleware('auth:sanctum');

Route::post('/lists/{list}/reorder', ReorderListController::class)->middleware('auth:sanctum')->whereNumber('list');

Route::post('/notifications/read-all', ReadAllNotificationsController::class)->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->controller(AccountController::class)->group(static function (): void {
    Route::delete('/account', 'destroy');
    Route::get('/account/export', 'export');
});
