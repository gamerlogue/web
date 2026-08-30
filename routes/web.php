<?php

declare(strict_types=1);

use App\Http\Controllers\AssetLinksController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\SanctumTokenController;
use Illuminate\Support\Facades\Route;

Route::get('/', static fn (): string => 'OK');

Route::post('/sanctum/token', [SanctumTokenController::class, 'issue'])
    ->middleware(['auth', 'throttle:6,1']);

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
