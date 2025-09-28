<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

test('returns error if not configured', function () {
    config()->set('services.igdb.client_id', null);
    config()->set('services.igdb.access_token', null);

    $this->get('/igdb/games')
        ->assertStatus(500)
        ->assertJson([
            'error' => 'IGDB service not configured',
        ]);
});

test('caches successful get response', function () {
    Cache::flush();

    Http::fake([
        'https://api.igdb.com/v4/games*' => Http::response('[{"id":1}]', 200, ['Content-Type' => 'application/json']),
    ]);

    // Prima richiesta: deve colpire l'upstream (finto)
    $this->get('/igdb/games')
        ->assertOk()
        ->assertHeader('X-IGDB-Proxy-Cached', '0')
        ->assertContent('[{"id":1}]');

    // Seconda richiesta identica: deve arrivare da cache
    $this->get('/igdb/games')
        ->assertOk()
        ->assertHeader('X-IGDB-Proxy-Cached', '1')
        ->assertContent('[{"id":1}]');

    Http::assertSentCount(1);
});
