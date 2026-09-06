<?php

declare(strict_types=1);

use App\Models\User;
use App\Notifications\RefreshTokenReuseAlert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use Reiarseni\SanctumRefreshToken\Enums\RevocationReason;
use Reiarseni\SanctumRefreshToken\RefreshTokenManager;
use Reiarseni\SanctumRefreshToken\SanctumRefreshToken;

uses(RefreshDatabase::class);

// The grace-replay recorder and the alert dedupe both write to the cache; an array store keeps one
// test's counters out of the next one's.
beforeEach(function () {
    config()->set('cache.default', 'array');
});

/**
 * The pair as the endpoint hands it out, minted through the manager rather than through the PKCE
 * dance: this file is about rotation, and SanctumTokenExchangeTest already owns the dance.
 *
 * @return array{0: User, 1: array<string, mixed>}
 */
function issuedPair(): array
{
    $user = User::factory()->create();

    $pair = app(RefreshTokenManager::class)->issue($user, 'mobile');

    return [$user, [
        'access_token' => $pair->accessToken,
        'refresh_token' => $pair->refreshToken,
        'expires_at' => $pair->accessTokenExpiresAt?->toIso8601ZuluString(),
        'refresh_expires_at' => $pair->refreshTokenExpiresAt?->toIso8601ZuluString(),
    ]];
}

function refresh(string $refreshToken): TestResponse
{
    return test()->postJson('/api/sanctum/token/refresh', ['refresh_token' => $refreshToken]);
}

test('the exchange hands out a pair with the agreed lifetimes', function () {
    [$user, $pair] = issuedPair();

    // ISO-8601 with an offset, not a Unix timestamp: kotlin.time.Instant.parse reads this.
    expect($pair['expires_at'])->toEndWith('Z')
        ->and($pair['refresh_expires_at'])->toEndWith('Z');

    expect(Carbon\Carbon::parse($pair['expires_at'])->diffInMinutes(now(), true))
        ->toBeGreaterThan(14.0)->toBeLessThan(16.0);

    expect(Carbon\Carbon::parse($pair['refresh_expires_at'])->diffInDays(now(), true))
        ->toBeGreaterThan(29.0)->toBeLessThan(31.0);

    expect($user->tokens()->sole()->abilities)->toBe(['library', 'profile']);
});

test('a refresh returns a new pair and kills the previous access token', function () {
    [$user, $pair] = issuedPair();

    $headers = ['Accept' => 'application/vnd.api+json', 'Authorization' => "Bearer {$pair['access_token']}"];

    $this->getJson("/api/users/{$user->id}", $headers)->assertOk();

    $next = refresh($pair['refresh_token'])
        ->assertOk()
        ->assertJsonPath('user_id', $user->id)
        ->assertJsonStructure(['access_token', 'refresh_token', 'user_id', 'expires_at', 'refresh_expires_at'])
        ->json();

    expect($next['access_token'])->not->toBe($pair['access_token'])
        ->and($next['refresh_token'])->not->toBe($pair['refresh_token']);

    // The guard caches the user it resolved above; a real request never reuses a resolved guard.
    auth()->forgetGuards();

    $this->getJson("/api/users/{$user->id}", $headers)->assertUnauthorized();

    auth()->forgetGuards();

    $this->getJson("/api/users/{$user->id}", [
        'Accept' => 'application/vnd.api+json',
        'Authorization' => "Bearer {$next['access_token']}",
    ])->assertOk();
});

test('a replay inside the grace window reissues instead of revoking', function () {
    [$user, $pair] = issuedPair();

    $first = refresh($pair['refresh_token'])->assertOk()->json();

    // The lost-response retry: the client never saw $first and sends the same token again.
    $second = refresh($pair['refresh_token'])->assertOk()->json();

    expect($second['refresh_token'])->not->toBe($first['refresh_token']);

    // The family survived, and the pair the retry got is usable.
    expect(SanctumRefreshToken::query()->where('tokenable_id', $user->id)->whereNull('revoked_at')->exists())
        ->toBeTrue();

    refresh($second['refresh_token'])->assertOk();
});

test('a replay after the grace window burns the family and leaves a log line', function () {
    Log::spy();

    [$user, $pair] = issuedPair();

    refresh($pair['refresh_token'])->assertOk();

    $this->travel(60)->seconds();

    refresh($pair['refresh_token'])
        ->assertStatus(401)
        ->assertJsonPath('error', 'refresh_token_reused');

    expect(SanctumRefreshToken::query()->where('tokenable_id', $user->id)->whereNull('revoked_at')->exists())
        ->toBeFalse();

    Log::shouldHaveReceived('warning')
        ->withArgs(fn (string $message, array $context): bool => $message === 'Refresh token reuse detected'
            && $context['user_id'] === $user->id
            && is_string($context['family_uuid'])
            && array_key_exists('ip', $context))
        ->once();

    Log::shouldHaveReceived('info')
        ->withArgs(fn (string $message, array $context): bool => $message === 'Token family revoked'
            && $context['reason'] === RevocationReason::ReuseDetected->value)
        ->once();
});

/**
 * ponytail: sequential, not concurrent. Real interleaving needs SELECT ... FOR UPDATE, which the
 * sqlite connection the suite runs on does not have — the package skips its own ConcurrencyTest
 * there for the same reason and proves the anchor lock on MySQL and PostgreSQL in CI. What this
 * asserts is the invariant that survives either way: no fork, one live generation.
 */
test('two refreshes with the same token leave exactly one live generation', function () {
    [$user, $pair] = issuedPair();

    $outcomes = [refresh($pair['refresh_token']), refresh($pair['refresh_token'])];

    $accepted = array_filter($outcomes, fn ($response): bool => $response->status() === 200);

    expect($accepted)->not->toBeEmpty();

    foreach ($outcomes as $response) {
        expect($response->status())->toBeIn([200, 409]);

        if ($response->status() === 409) {
            $response->assertJsonPath('error', 'rotation_in_progress');
        }
    }

    $live = SanctumRefreshToken::query()
        ->where('tokenable_id', $user->id)
        ->whereNull('revoked_at')
        ->whereNull('rotated_at')
        ->count();

    expect($live)->toBe(1);
});

test('a refresh against an expired family is refused and mints nothing', function () {
    [$user, $pair] = issuedPair();

    // Past the 180-day family cap, but not past the refresh token's own sliding 30 days, so the
    // refusal can only come from the family.
    SanctumRefreshToken::query()
        ->where('tokenable_id', $user->id)
        ->update(['family_expires_at' => now()->subMinute()]);

    $before = $user->tokens()->count();

    refresh($pair['refresh_token'])
        ->assertStatus(401)
        ->assertJsonPath('error', 'family_expired');

    expect($user->tokens()->count())->toBe($before);
});

test('an unknown refresh token is refused with the logout code', function () {
    refresh('999|' . str_repeat('a', 43))
        ->assertStatus(401)
        ->assertJsonPath('error', 'refresh_token_invalid');
});

test('a revoked family reads as refresh_token_invalid rather than its own code', function () {
    [$user, $pair] = issuedPair();

    app(RefreshTokenManager::class)->revokeAllFamilies($user);

    refresh($pair['refresh_token'])
        ->assertStatus(401)
        ->assertJsonPath('error', 'refresh_token_invalid');
});

test('a refusal records the code the package raised, not the collapsed one', function () {
    Log::spy();

    [, $pair] = issuedPair();

    $this->travel(31)->days();

    refresh($pair['refresh_token'])
        ->assertStatus(401)
        ->assertJsonPath('error', 'refresh_token_invalid');

    Log::shouldHaveReceived('info')
        ->withArgs(fn (string $message, array $context): bool => $message === 'Refresh token refused'
            && $context['error'] === 'refresh_token_invalid'
            && $context['package_error'] === 'refresh_token_expired')
        ->once();
});

test('a detected reuse alerts the administrator once per storm', function () {
    Notification::fake();
    config()->set('app.admin_email', 'admin@gamerlogue.test');

    $user = User::factory()->create();
    $manager = app(RefreshTokenManager::class);

    $phone = $manager->issue($user, 'mobile');
    $desktop = $manager->issue($user, 'desktop');

    refresh($phone->refreshToken)->assertOk();
    refresh($desktop->refreshToken)->assertOk();

    $this->travel(60)->seconds();

    // Two of the same user's families replayed is one incident, not two mails.
    refresh($phone->refreshToken)->assertStatus(401)->assertJsonPath('error', 'refresh_token_reused');
    refresh($desktop->refreshToken)->assertStatus(401)->assertJsonPath('error', 'refresh_token_reused');

    Notification::assertSentOnDemand(RefreshTokenReuseAlert::class);
    Notification::assertCount(1);

    // A different user is a different incident.
    [, $other] = issuedPair();

    refresh($other['refresh_token'])->assertOk();

    $this->travel(60)->seconds();

    refresh($other['refresh_token'])->assertStatus(401);

    Notification::assertCount(2);

    // And a fresh storm against the same user, once the dedupe window is behind us, alerts again:
    // the guard suppresses the loop, not the next incident.
    $laptop = $manager->issue($user, 'laptop');

    refresh($laptop->refreshToken)->assertOk();

    $this->travel(6)->minutes();

    refresh($laptop->refreshToken)->assertStatus(401)->assertJsonPath('error', 'refresh_token_reused');

    Notification::assertCount(3);
});

test('no alert is sent when no administrator is configured', function () {
    Notification::fake();
    config()->set('app.admin_email', '');

    [, $pair] = issuedPair();

    refresh($pair['refresh_token'])->assertOk();

    $this->travel(60)->seconds();

    refresh($pair['refresh_token'])->assertStatus(401);

    Notification::assertNothingSent();
});
