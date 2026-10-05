<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Uri;
use Reiarseni\SanctumRefreshToken\Exceptions\SanctumRefreshTokenException;
use Reiarseni\SanctumRefreshToken\RefreshTokenManager;
use Reiarseni\SanctumRefreshToken\SanctumRefreshToken;
use Reiarseni\SanctumRefreshToken\ValueObjects\TokenPair;

/**
 * Hands a Sanctum token to a native client through a single-use authorization code, bound to the
 * client by PKCE (RFC 7636). The token never travels in the redirect URL, and a code intercepted
 * from the redirect is useless without the verifier that never left the client.
 */
class SanctumTokenController
{
    public function __construct(private readonly RefreshTokenManager $manager) {}

    /**
     * Native tokens are limited to the resources the app actually uses, instead of ['*'].
     * Enforced in LibraryEntryFormRequest and UserFormRequest.
     */
    public const ABILITIES = ['library', 'profile'];

    public function issue(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'token_name' => ['required', 'string', 'max:255'],
            'redirect_uri' => [
                'sometimes',
                'bail',
                'string',
                static function (string $attribute, string $value, Closure $fail): void {
                    if (! self::isAllowedRedirectUri($value)) {
                        $fail('validation.in')->translate();
                    }
                },
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

        return response()->json(self::pairPayload(
            $this->manager->issue($user, $pending['token_name']),
            $user->id,
        ));
    }

    /**
     * Exchanges a refresh token for the next generation of its family. Unauthenticated by design:
     * the refresh token is the credential, and the access token it replaces is expected to be dead.
     */
    public function refresh(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'refresh_token' => ['required', 'string'],
        ]);

        try {
            $pair = $this->manager->rotate($validated['refresh_token']);
        } catch (SanctumRefreshTokenException $e) {
            $code = self::clientErrorCode($e->errorCode());

            // Precise in the log, collapsed in the response. Without this line an expired token, a
            // revoked one and one that never existed are the same event in production, and the
            // answer to "why does it keep logging me out" is not recoverable after the fact.
            Log::info('Refresh token refused', [
                'error' => $code,
                'package_error' => $e->errorCode(),
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'error' => $code,
                'message' => $e->getMessage(),
            ], $code === 'rotation_in_progress' ? 409 : 401);
        }

        // The family is the only handle the pair carries back, and the rotation just appended the
        // newest generation to it.
        /** @var int|string $userId */
        $userId = SanctumRefreshToken::query()
            ->where('family_uuid', $pair->familyUuid)
            ->latest('generation')
            ->value('tokenable_id');

        return response()->json(self::pairPayload($pair, $userId));
    }

    /**
     * Ends a native session. Unauthenticated for the same reason as refresh: the refresh token is
     * the credential, and a client signing out has usually already let its access token expire.
     *
     * Idempotent — an unknown token answers 204 too. A logout that can fail is a logout a client
     * retries, and there is nothing here worth telling an unauthenticated caller apart.
     */
    public function revoke(Request $request): Response
    {
        $validated = $request->validate([
            'refresh_token' => ['required', 'string'],
        ]);

        try {
            $this->manager->revokeByRefreshToken($validated['refresh_token']);
        } catch (SanctumRefreshTokenException) {
            // Nothing to revoke. TokenFamilyRevoked is not dispatched, so nothing is logged either.
        }

        return response()->noContent();
    }

    /**
     * The pair as the KMP client reads it. Zulu ISO-8601 rather than TokenPair::toArray(), whose
     * keys and `+00:00` offset are not the contract the client parses.
     *
     * @return array{
     *     access_token: string,
     *     refresh_token: string,
     *     user_id: int|string,
     *     expires_at: string|null,
     *     refresh_expires_at: string|null,
     * }
     */
    private static function pairPayload(TokenPair $pair, int|string $userId): array
    {
        return [
            'access_token' => $pair->accessToken,
            'refresh_token' => $pair->refreshToken,
            'user_id' => $userId,
            'expires_at' => $pair->accessTokenExpiresAt?->toIso8601ZuluString(),
            'refresh_expires_at' => $pair->refreshTokenExpiresAt?->toIso8601ZuluString(),
        ];
    }

    /**
     * Collapses the package's error codes onto the four the client branches on. Everything that is
     * not a live security signal or a benign race reads as `refresh_token_invalid`, which the
     * client treats as a forced logout — the right outcome for an expired or revoked token too.
     */
    private static function clientErrorCode(string $packageCode): string
    {
        return match ($packageCode) {
            'refresh_token_reused', 'family_expired', 'rotation_in_progress' => $packageCode,
            default => 'refresh_token_invalid',
        };
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

    /**
     * RFC 8252 §7.3: a loopback redirect matches its allowlisted entry whatever the port, because a
     * desktop client binds an ephemeral one at runtime. Allowlist it without the port.
     */
    private static function isAllowedRedirectUri(string $uri): bool
    {
        $allowed = config('services.native_auth.redirect_uris');
        $withoutPort = preg_replace('~^http://(127\.0\.0\.1|\[::1]|localhost):\d+(?=[/?#]|$)~', 'http://$1', $uri);

        return in_array($uri, $allowed, true) || in_array($withoutPort, $allowed, true);
    }

    private static function cacheKey(string $code): string
    {
        return 'sanctum_token_exchange:' . hash('sha256', $code);
    }
}
