<?php

declare(strict_types=1);

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\SanctumTokenController;
use Illuminate\Support\Facades\Route;

Route::get('/', static fn (): string => 'OK');

Route::post('/sanctum/token', [SanctumTokenController::class, 'issue'])
    ->middleware(['auth', 'throttle:6,1']);

/**
 * Service routes
 */
Route::patch('/set-locale', [LocaleController::class, 'update'])->name('set-locale');
