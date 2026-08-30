<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

uses(RefreshDatabase::class);

/** RFC 7636 appendix B: pinning the pair makes any change to the S256 encoding fail loudly. */
const RFC_VERIFIER = 'dBjftJeZ4CVP-mB92K27uhbUJU1p1r_wW1gFWFOEjXk';
const RFC_CHALLENGE = 'E9Melhoa2OwvFrEMTJguCHaoeK1t8URWbuGJSstw-cM';

beforeEach(function () {
    config()->set('cache.default', 'array');
    config()->set('services.native_auth.redirect_uris', ['gamerlogue://auth/callback']);
    Cache::flush();
});

/**
 * @param  array<string, string>  $overrides
 * @return array<string, string>
 */
function issuePayload(array $overrides = []): array
{
    return [
        'token_name' => 'mobile',
        'code_challenge' => RFC_CHALLENGE,
        'code_challenge_method' => 'S256',
        'state' => 'a-high-entropy-client-value',
        ...$overrides,
    ];
}

/** @return array<string, string> */
function issuedQuery(User $user, array $overrides = []): array
{
    $response = test()->actingAs($user)->post('/sanctum/token', issuePayload($overrides));

    $response->assertRedirect();

    parse_str((string) parse_url((string) $response->headers->get('Location'), PHP_URL_QUERY), $query);

    return $query;
}

test('token issuance only accepts post requests', function () {
    $this->actingAs(User::factory()->create())
        ->get('/sanctum/token?token_name=mobile')
        ->assertMethodNotAllowed();
});

test('token issuance rejects untrusted redirect uris', function () {
    $this->actingAs(User::factory()->create())
        ->postJson('/sanctum/token', issuePayload(['redirect_uri' => 'https://attacker.example/callback']))
        ->assertUnprocessable()
        ->assertJsonValidationErrors('redirect_uri');
});

test('token issuance requires a PKCE challenge and a state', function (string $field) {
    $payload = issuePayload();
    unset($payload[$field]);

    $this->actingAs(User::factory()->create())
        ->postJson('/sanctum/token', $payload)
        ->assertUnprocessable()
        ->assertJsonValidationErrors($field);
})->with(['code_challenge', 'code_challenge_method', 'state']);

test('token issuance refuses the plain challenge method', function () {
    $this->actingAs(User::factory()->create())
        ->postJson('/sanctum/token', issuePayload(['code_challenge_method' => 'plain']))
        ->assertUnprocessable()
        ->assertJsonValidationErrors('code_challenge_method');
});

test('the state is returned to the client unmodified', function () {
    $query = issuedQuery(User::factory()->create(), ['state' => 'opaque-value-123']);

    expect($query['state'])->toBe('opaque-value-123');
});

test('a token is exchanged through a single use authorization code', function () {
    $user = User::factory()->create();

    $query = issuedQuery($user);

    expect($query)
        ->toHaveKey('code')
        ->not->toHaveKey('token');

    $response = $this->postJson('/api/sanctum/token/exchange', [
        'code' => $query['code'],
        'code_verifier' => RFC_VERIFIER,
    ]);

    $response->assertOk()
        ->assertJsonPath('user_id', $user->id)
        ->assertJsonStructure(['token', 'user_id', 'expires_at']);

    $this->postJson('/api/sanctum/token/exchange', [
        'code' => $query['code'],
        'code_verifier' => RFC_VERIFIER,
    ])->assertUnprocessable();
});

test('the issued token expires and carries explicit abilities', function () {
    $user = User::factory()->create();

    $query = issuedQuery($user);

    $this->postJson('/api/sanctum/token/exchange', [
        'code' => $query['code'],
        'code_verifier' => RFC_VERIFIER,
    ])->assertOk();

    $token = $user->tokens()->sole();

    expect($token->abilities)->toBe(['library', 'profile'])
        ->and($token->expires_at)->not->toBeNull()
        ->and($token->expires_at->isFuture())->toBeTrue();
});

test('a code stolen from the redirect is useless without the verifier', function () {
    $user = User::factory()->create();

    $query = issuedQuery($user);

    $this->postJson('/api/sanctum/token/exchange', [
        'code' => $query['code'],
        'code_verifier' => str_repeat('a', 43),
    ])->assertUnprocessable();

    expect($user->tokens()->count())->toBe(0);
});

test('a failed verification burns the code', function () {
    $user = User::factory()->create();

    $query = issuedQuery($user);

    $this->postJson('/api/sanctum/token/exchange', [
        'code' => $query['code'],
        'code_verifier' => str_repeat('a', 43),
    ])->assertUnprocessable();

    $this->postJson('/api/sanctum/token/exchange', [
        'code' => $query['code'],
        'code_verifier' => RFC_VERIFIER,
    ])->assertUnprocessable();
});

test('an unredeemed code leaves no token behind', function () {
    $user = User::factory()->create();

    issuedQuery($user);

    expect($user->tokens()->count())->toBe(0);
});

test('the token stops working once it expires', function () {
    $user = User::factory()->create();

    $query = issuedQuery($user);

    $token = $this->postJson('/api/sanctum/token/exchange', [
        'code' => $query['code'],
        'code_verifier' => RFC_VERIFIER,
    ])->assertOk()->json('token');

    // issuedQuery() authenticated a session, which would answer the requests below and hide
    // whether the bearer token is doing anything at all.
    auth()->forgetGuards();

    $headers = ['Accept' => 'application/vnd.api+json', 'Authorization' => "Bearer {$token}"];

    $this->getJson("/api/users/{$user->id}", $headers)->assertOk();

    $this->travel(31)->days();

    // Again: the guard caches the user it resolved on the request above and would not re-check
    // the token. A real request never reuses a resolved guard this way.
    auth()->forgetGuards();

    $this->getJson("/api/users/{$user->id}", $headers)->assertUnauthorized();
});

test('a redirect uri that already carries a query keeps it', function () {
    config()->set('services.native_auth.redirect_uris', ['https://gamerlogue.test/auth/callback?source=app']);

    $query = issuedQuery(User::factory()->create(), [
        'redirect_uri' => 'https://gamerlogue.test/auth/callback?source=app',
    ]);

    expect($query)->toHaveKey('source', 'app')
        ->and($query)->toHaveKey('code');
});
