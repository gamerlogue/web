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
    $response = test()->actingAs($user)->get('/sanctum/token?' . http_build_query(issuePayload($overrides)));

    $response->assertRedirect();

    parse_str((string) parse_url((string) $response->headers->get('Location'), PHP_URL_QUERY), $query);

    return $query;
}

/**
 * GET so a Custom Tab can navigate to it. The request is safe to expose that way: it mints no
 * token by itself, only the intent behind a single-use code that is worthless without the
 * verifier, and the redirect target has to be on the allowlist.
 */
test('token issuance is navigable and refuses other verbs', function () {
    $this->actingAs(User::factory()->create())
        ->post('/sanctum/token', issuePayload())
        ->assertMethodNotAllowed();
});

test('token issuance rejects untrusted redirect uris', function () {
    $payload = issuePayload(['redirect_uri' => 'https://attacker.example/callback']);

    $this->actingAs(User::factory()->create())
        ->getJson('/sanctum/token?' . http_build_query($payload))
        ->assertUnprocessable()
        ->assertJsonValidationErrors('redirect_uri');
});

test('token issuance requires a PKCE challenge and a state', function (string $field) {
    $payload = issuePayload();
    unset($payload[$field]);

    $this->actingAs(User::factory()->create())
        ->getJson('/sanctum/token?' . http_build_query($payload))
        ->assertUnprocessable()
        ->assertJsonValidationErrors($field);
})->with(['code_challenge', 'code_challenge_method', 'state']);

test('token issuance refuses the plain challenge method', function () {
    $this->actingAs(User::factory()->create())
        ->getJson('/sanctum/token?' . http_build_query(issuePayload(['code_challenge_method' => 'plain'])))
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

/**
 * The navigable endpoint can be triggered cross-site, since a GET carries no CSRF token. That is
 * survivable only because the code it mints is bound to a challenge the triggering page cannot
 * pair with a verifier, and lands on an allowlisted redirect the attacker cannot read.
 */
test('a code minted by a cross-site trigger is unusable', function () {
    $user = User::factory()->create();

    // The attacker picks the challenge, so they hold the matching verifier.
    $query = issuedQuery($user, ['code_challenge' => RFC_CHALLENGE]);

    // But the redirect is still on the allowlist, and the app that receives the code exchanges it
    // with its own verifier, which does not match.
    $this->postJson('/api/sanctum/token/exchange', [
        'code' => $query['code'],
        'code_verifier' => str_repeat('b', 43),
    ])->assertUnprocessable();

    expect($user->tokens()->count())->toBe(0);
});

test('the authorize endpoint mints no token on its own', function () {
    $user = User::factory()->create();

    issuedQuery($user);
    issuedQuery($user);
    issuedQuery($user);

    // Prefetchers and scanners can follow a GET. Codes that are never redeemed expire without
    // ever having created anything.
    expect($user->tokens()->count())->toBe(0);
});

/**
 * The whole point of the endpoint being navigable: a Custom Tab opens it, an unauthenticated
 * caller is sent through OIDC, and the intended URL brings the parameters back afterwards, so
 * the client does not have to reissue the request itself.
 */
test('an unauthenticated visitor is sent through OIDC and comes back to the same request', function () {
    $response = $this->get('/sanctum/token?' . http_build_query(issuePayload()))
        ->assertRedirect(route('oidc.login'));

    // Laravel normalises the query order, so compare the parameters rather than the raw string.
    parse_str((string) parse_url((string) session('url.intended'), PHP_URL_QUERY), $intended);

    expect($intended)->toEqualCanonicalizing(issuePayload())
        ->and($response->headers->get('Location'))->toBe(route('oidc.login'));
});
