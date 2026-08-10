<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

uses(RefreshDatabase::class);

beforeEach(function () {
    config()->set('cache.default', 'array');
    config()->set('services.native_auth.redirect_uris', ['gamerlogue://auth/callback']);
    Cache::flush();
});

test('token issuance only accepts post requests', function () {
    $this->actingAs(User::factory()->create())
        ->get('/sanctum/token?token_name=mobile')
        ->assertMethodNotAllowed();
});

test('token issuance rejects untrusted redirect uris', function () {
    $this->actingAs(User::factory()->create())
        ->postJson('/sanctum/token', [
            'token_name' => 'mobile',
            'redirect_uri' => 'https://attacker.example/callback',
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('redirect_uri');
});

test('a token is exchanged through a single use authorization code', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/sanctum/token', [
        'token_name' => 'mobile',
        'redirect_uri' => 'gamerlogue://auth/callback',
    ]);

    $response->assertRedirect();

    parse_str((string) parse_url((string) $response->headers->get('Location'), PHP_URL_QUERY), $query);

    expect($query)
        ->toHaveKey('code')
        ->not->toHaveKey('token');

    $this->postJson('/api/sanctum/token/exchange', ['code' => $query['code']])
        ->assertOk()
        ->assertJsonPath('user_id', $user->id)
        ->assertJsonStructure(['token', 'user_id']);

    $this->postJson('/api/sanctum/token/exchange', ['code' => $query['code']])
        ->assertUnprocessable();
});

test('an unredeemed code leaves no token behind', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/sanctum/token', ['token_name' => 'mobile'])
        ->assertRedirect();

    expect($user->tokens()->count())->toBe(0);
});
