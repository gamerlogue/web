<?php

declare(strict_types=1);

/**
 * Horizon keys its supervisors by APP_ENV. An environment missing from the list is not an error:
 * Horizon starts, finds nothing to supervise, and the queue silently never drains.
 */
test('the running environment has supervisors', function (string $environment) {
    expect(config("horizon.environments.{$environment}"))->not->toBeEmpty();
})->with(['local', 'production']);

test('every supervisor watches a redis connection', function () {
    $connections = collect(config('horizon.environments'))
        ->flatMap(fn (array $supervisors): array => array_keys($supervisors))
        ->unique()
        ->map(fn (string $supervisor): ?string => config("horizon.defaults.{$supervisor}.connection"));

    expect($connections)->each->toBe('redis');
});

/**
 * Horizon only supervises the connection its supervisors name, so that connection has to exist
 * and has to be a Redis one. Asserting on queue.default instead would prove nothing: the suite
 * pins it to 'sync', so the check would skip everywhere including CI.
 */
test('every connection horizon supervises exists and is redis', function () {
    $connections = collect(config('horizon.defaults'))
        ->pluck('connection')
        ->unique();

    expect($connections)->not->toBeEmpty()
        ->and($connections->every(fn (string $connection): bool => config("queue.connections.{$connection}.driver") === 'redis'))
        ->toBeTrue();
});
