<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

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

    $query = "fields id; limit $count;";
    $this->post('/api/igdb/games', [$query])
        ->assertOk()
//        ->dump()
        ->assertJsonCount($count);

    $this->assertTrue(Cache::has(config('igdb.cache_prefix', 'igdb_cache').'.'.md5('games'.$query)));
});
