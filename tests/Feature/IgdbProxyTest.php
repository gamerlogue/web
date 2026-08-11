<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    config()->set('cache.default', 'array');
    Cache::flush();
    Http::preventStrayRequests();
});

test('forwards any igdb endpoint, for guests too', function (string $endpoint) {
    Cache::put('igdb_cache.access_token', 'test-token');
    Http::fake(['api.igdb.com/v4/*' => Http::response([['id' => 1]])]);

    $this->call('POST', "/api/igdb/{$endpoint}", server: ['CONTENT_TYPE' => 'text/plain'], content: 'fields id;')
        ->assertOk()
        ->assertJson([['id' => 1]]);

    Http::assertSent(static fn (Request $request): bool => $request->url() === "https://api.igdb.com/v4/{$endpoint}");
})->with(['games', 'covers', 'game_engines']);

test('rejects a path that is not an endpoint name', function () {
    $this->postJson('/api/igdb/../admin')->assertNotFound();
});

test('returns error if not configured', function () {
    config()->set('igdb.credentials.client_id');
    config()->set('igdb.credentials.access_token');

    $this->actingAs(User::factory()->create(), 'sanctum')
        ->postJson('/api/igdb/games')
        ->assertStatus(502)
        ->assertJsonPath('message', 'IGDB is temporarily unavailable.');
});

test('caches successful post responses', function () {
    config()->set('igdb.cache_lifetime', 3600);

    $count = 5;
    $games = array_map(
        static fn (int $id): array => ['id' => $id],
        range(1, $count),
    );

    Cache::put('igdb_cache.access_token', 'test-token');
    Http::fake([
        'api.igdb.com/v4/*' => Http::response($games),
    ]);

    $query = "fields id; limit $count;";
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum')
        ->call('POST', '/api/igdb/games', server: ['CONTENT_TYPE' => 'text/plain'], content: $query)
        ->assertOk()
        ->assertJson($games)
        ->assertJsonCount($count);

    $this->actingAs($user, 'sanctum')
        ->call('POST', '/api/igdb/games', server: ['CONTENT_TYPE' => 'text/plain'], content: $query)
        ->assertOk()
        ->assertJson($games);

    Http::assertSentCount(1);
    Http::assertSent(static fn (Request $request): bool => $request->body() === $query);
    $this->assertTrue(Cache::has(config('igdb.cache_prefix', 'igdb_cache') . '.' . md5('games' . $query)));
});

test('serves stale event data while refreshing it', function () {
    Cache::put('igdb_cache.access_token', 'test-token');
    Http::fake([
        'api.igdb.com/v4/*' => Http::sequence()
            ->push([['id' => 1]])
            ->push([['id' => 2]]),
    ]);

    $query = 'fields id;';
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum')
        ->call('POST', '/api/igdb/events', server: ['CONTENT_TYPE' => 'text/plain'], content: $query)
        ->assertOk()
        ->assertJson([['id' => 1]]);

    $this->travel(6)->seconds();

    $this->actingAs($user, 'sanctum')
        ->call('POST', '/api/igdb/events', server: ['CONTENT_TYPE' => 'text/plain'], content: $query)
        ->assertOk()
        ->assertJson([['id' => 1]]);

    $this->actingAs($user, 'sanctum')
        ->call('POST', '/api/igdb/events', server: ['CONTENT_TYPE' => 'text/plain'], content: $query)
        ->assertOk()
        ->assertJson([['id' => 2]]);

    Http::assertSentCount(2);
});

test('does not cache upstream errors', function () {
    Cache::put('igdb_cache.access_token', 'test-token');
    Http::fake([
        'api.igdb.com/v4/*' => Http::sequence()
            ->push(['message' => 'Rate limited'], 429)
            ->push([['id' => 1]], 200),
    ]);

    $query = 'fields id;';
    $user = User::factory()->create();

    $this->actingAs($user, 'sanctum')
        ->call('POST', '/api/igdb/games', server: ['CONTENT_TYPE' => 'text/plain'], content: $query)
        ->assertTooManyRequests();

    $this->actingAs($user, 'sanctum')
        ->call('POST', '/api/igdb/games', server: ['CONTENT_TYPE' => 'text/plain'], content: $query)
        ->assertOk();

    Http::assertSentCount(2);
});

test('returns bad gateway when igdb cannot be reached', function () {
    Cache::put('igdb_cache.access_token', 'test-token');
    Http::fake([
        'api.igdb.com/v4/*' => Http::failedConnection(),
    ]);

    $this->actingAs(User::factory()->create(), 'sanctum')
        ->call('POST', '/api/igdb/games', server: ['CONTENT_TYPE' => 'text/plain'], content: 'fields id;')
        ->assertStatus(502)
        ->assertJsonPath('message', 'IGDB is temporarily unavailable.');
});

test('rejects oversized queries before contacting igdb', function () {
    $this->actingAs(User::factory()->create(), 'sanctum')
        ->call('POST', '/api/igdb/games', server: ['CONTENT_TYPE' => 'text/plain'], content: str_repeat('a', 16_385))
        ->assertStatus(413);

    Http::assertNothingSent();
});
