<?php

declare(strict_types=1);

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::preventStrayRequests();
});

test('returns error if not configured', function () {
    config()->set('igdb.credentials.client_id');
    config()->set('igdb.credentials.access_token');
    Cache::flush();

    $this->post('/api/igdb/games', ['fields id; where id = 1;'])
//        ->dump()
        ->assertStatus(500);
});

test('caches successful get response', function () {
    config()->set('igdb.cache_lifetime', 3600);
    Cache::flush();

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
    $this->call('POST', '/api/igdb/games', server: ['CONTENT_TYPE' => 'text/plain'], content: $query)
        ->assertOk()
        ->assertJson($games)
        ->assertJsonCount($count);

    $this->call('POST', '/api/igdb/games', server: ['CONTENT_TYPE' => 'text/plain'], content: $query)
        ->assertOk()
        ->assertJson($games);

    Http::assertSentCount(1);
    Http::assertSent(static fn (Request $request): bool => $request->body() === $query);
    $this->assertTrue(Cache::has(config('igdb.cache_prefix', 'igdb_cache') . '.' . md5('games' . $query)));
});
