<?php

use App\Http\Controllers\LocaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return "OK";
//    return redirect()
//        // Resend the session data to the frontend to avoid losing it
//        ->with(request()->session()->all());
});

Route::get('/sanctum/token', static function (Request $request) {
    if (! $request->query->has('token_name')) {
        return response()->json(['message' => 'The token_name query parameter is required.'], 422);
    }

    $token = $request->user()->createToken($request->query('token_name'));

    $redirectUri = $request->query('redirect_uri', 'gamerlogue://auth/callback');

    $encoded_token = urlencode($token->plainTextToken);
    // Build query string
    $queryString = http_build_query([
        'token' => $encoded_token,
        'user_id' => $request->user()->id,
    ]);

    return redirect()->away("$redirectUri?$queryString");
})->middleware('auth');

/**
 * Service routes
 */
Route::patch('/set-locale', [LocaleController::class, 'update'])->name('set-locale');
