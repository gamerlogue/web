<?php

declare(strict_types=1);

use App\Http\Controllers\AssetLinksController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\SanctumTokenController;
use Illuminate\Support\Facades\Route;

Route::get('/', static fn (): string => 'OK');

/*
 * GET, so a native client can open it in a Custom Tab or system browser: a POST is not
 * navigable. This mirrors OAuth 2.0's /authorize endpoint, and rests on the same defences —
 * the redirect_uri allowlist, mandatory PKCE and a client-generated state. The request creates
 * no token on its own: it only records the intent behind a single-use code.
 */
Route::get('/sanctum/token', [SanctumTokenController::class, 'issue'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('native.authorize');

/*
 * Where the App Link lands when Android does not intercept it: an unverified install, a debug
 * build before assetlinks is published, or a desktop browser. Without it the user meets a 404
 * holding an authorization code, at the exact moment something has already gone wrong.
 */
Route::view('/auth/callback', 'auth-callback')->name('native.callback');

/*
 * Digital Asset Links for the Android App Link. Public and unauthenticated by definition: Android
 * fetches it before any user is involved. Caddy's (security) snippet rejects dot-prefixed path
 * segments but exempts /.well-known/*, so this is reachable in production.
 */
Route::get('/.well-known/assetlinks.json', AssetLinksController::class)->name('assetlinks');

/**
 * Service routes
 */
Route::patch('/set-locale', [LocaleController::class, 'update'])->name('set-locale');
