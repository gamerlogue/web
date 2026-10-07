<?php

declare(strict_types=1);

/**
 * JSON:API has no documentation normalizer: listing it in `docs_formats` routes the request to
 * the Hydra documentation, which the JSON:API serializer cannot normalize (500).
 */
test('the documentation is not offered as json:api', function () {
    $this->get('/api/docs.jsonapi')->assertNotFound();
});

test('the documentation is served as openapi', function () {
    $response = $this->get('/api/docs.jsonopenapi')
        ->assertOk()
        ->assertJsonStructure(['openapi', 'info', 'paths']);

    expect($response->json('openapi'))->toMatch('/^3\.\d+\.\d+$/');
});

test('the documentation ui embeds openapi and uses current published assets', function () {
    $response = $this->get('/api', ['Accept' => 'text/html'])->assertOk();
    $html = $response->getContent();

    expect(preg_match('/<script id="swagger-data"[^>]*>(.*?)<\/script>/s', $html, $matches))->toBe(1);

    $data = json_decode($matches[1], true, 512, JSON_THROW_ON_ERROR);

    expect($data['spec']['openapi'])->toMatch('/^3\.\d+\.\d+$/');
    expect($data['spec']['paths'])->not->toBeEmpty();

    preg_match_all('/(?:src|href)="\/vendor\/api-platform\/([^"]+)"/', $html, $assets);

    expect($assets[1])->not->toBeEmpty();

    foreach (array_unique($assets[1]) as $asset) {
        $published = public_path('vendor/api-platform/' . $asset);

        expect($published)->toBeFile();
        expect(hash_file('sha256', $published))
            ->toBe(hash_file('sha256', base_path('vendor/api-platform/laravel/public/' . $asset)));
    }
});
