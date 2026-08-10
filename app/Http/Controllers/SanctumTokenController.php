<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Hands a Sanctum token to a native client through a single-use authorization code,
 * so the token never travels in the redirect URL.
 */
class SanctumTokenController
{
    public function issue(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'token_name' => ['required', 'string', 'max:255'],
            'redirect_uri' => [
                'sometimes',
                'string',
                Rule::in(config('services.native_auth.redirect_uris')),
            ],
        ]);

        $code = Str::random(64);

        // Only the intent is stored: a code that is never redeemed expires without ever having
        // created a token, instead of leaving a valid one behind forever.
        Cache::put(self::cacheKey($code), [
            'user_id' => $request->user()->id,
            'token_name' => $validated['token_name'],
        ], now()->addMinute());

        $redirectUri = $validated['redirect_uri'] ?? config('services.native_auth.redirect_uris.0');

        return redirect()->away($redirectUri . '?' . http_build_query(['code' => $code]));
    }

    public function exchange(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'size:64'],
        ]);

        $cacheKey = self::cacheKey($validated['code']);

        $pending = Cache::lock($cacheKey . ':lock', 5)->block(
            2,
            static fn () => Cache::pull($cacheKey),
        );

        abort_if($pending === null, 422, 'The authorization code is invalid or expired.');

        $user = User::find($pending['user_id']);

        abort_if($user === null, 422, 'The authorization code is invalid or expired.');

        return response()->json([
            'token' => $user->createToken($pending['token_name'])->plainTextToken,
            'user_id' => $user->id,
        ]);
    }

    private static function cacheKey(string $code): string
    {
        return 'sanctum_token_exchange:' . hash('sha256', $code);
    }
}
