<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Uri;
use Illuminate\Validation\Rule;

/**
 * Hands a Sanctum token to a native client through a single-use authorization code, bound to the
 * client by PKCE (RFC 7636). The token never travels in the redirect URL, and a code intercepted
 * from the redirect is useless without the verifier that never left the client.
 */
class SanctumTokenController
{
    /**
     * Native tokens are limited to the resources the app actually uses, instead of ['*'].
     * Enforced in LibraryEntryFormRequest and UserFormRequest.
     */
    private const ABILITIES = ['library', 'profile'];

    private const TOKEN_LIFETIME_DAYS = 30;

    public function issue(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'token_name' => ['required', 'string', 'max:255'],
            'redirect_uri' => [
                'sometimes',
                'string',
                Rule::in(config('services.native_auth.redirect_uris')),
            ],
            // S256 only: 'plain' would leave the code bound to a value the interceptor can read
            // out of the same redirect it stole the code from.
            'code_challenge' => ['required', 'string', 'size:43', 'regex:/^[A-Za-z0-9\-_]+$/'],
            'code_challenge_method' => ['required', 'string', 'in:S256'],
            // Correlates the callback with the login this client started, per RFC 8252.
            'state' => ['required', 'string', 'max:512'],
        ]);

        $code = Str::random(64);

        // Only the intent is stored: a code that is never redeemed expires without ever having
        // created a token, instead of leaving a valid one behind forever.
        Cache::put(self::cacheKey($code), [
            'user_id' => $request->user()->id,
            'token_name' => $validated['token_name'],
            'code_challenge' => $validated['code_challenge'],
        ], now()->addMinute());

        $redirectUri = $validated['redirect_uri'] ?? config('services.native_auth.redirect_uris.0');

        // Uri::withQuery() merges, so an allowlisted redirect that already carries a query keeps it.
        return redirect()->away((string) Uri::of($redirectUri)->withQuery([
            'code' => $code,
            'state' => $validated['state'],
        ]));
    }

    public function exchange(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'size:64'],
            'code_verifier' => ['required', 'string', 'min:43', 'max:128', 'regex:/^[A-Za-z0-9\-._~]+$/'],
        ]);

        $cacheKey = self::cacheKey($validated['code']);

        // Pulled before the challenge is verified, so a wrong verifier burns the code rather than
        // leaving it available for another attempt.
        $pending = Cache::lock($cacheKey . ':lock', 5)->block(
            2,
            static fn () => Cache::pull($cacheKey),
        );

        abort_if($pending === null, 422, 'The authorization code is invalid or expired.');

        abort_unless(
            hash_equals($pending['code_challenge'], self::challengeFor($validated['code_verifier'])),
            422,
            'The authorization code is invalid or expired.',
        );

        $user = User::find($pending['user_id']);

        abort_if($user === null, 422, 'The authorization code is invalid or expired.');

        $token = $user->createToken(
            $pending['token_name'],
            self::ABILITIES,
            now()->addDays(self::TOKEN_LIFETIME_DAYS),
        );

        return response()->json([
            'token' => $token->plainTextToken,
            'user_id' => $user->id,
            'expires_at' => $token->accessToken->expires_at?->toIso8601String(),
        ]);
    }

    /**
     * The S256 transformation from RFC 7636 §4.2: base64url, unpadded, over the raw digest.
     */
    private static function challengeFor(string $verifier): string
    {
        return hash('sha256', $verifier, true)
            |> base64_encode(...)
            |> (static fn (string $base64): string => strtr($base64, '+/', '-_'))
            |> (static fn (string $base64url): string => rtrim($base64url, '='));
    }

    private static function cacheKey(string $code): string
    {
        return 'sanctum_token_exchange:' . hash('sha256', $code);
    }
}
