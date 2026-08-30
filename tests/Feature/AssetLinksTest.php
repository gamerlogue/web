<?php

declare(strict_types=1);

/** The real debug fingerprint, so the parsing is exercised against the shape Android prints. */
const DEBUG_FINGERPRINT = '5F:2C:21:6B:0F:F0:C9:3D:6A:B4:3E:8F:C7:10:74:05:2E:45:ED:ED:B1:2F:DB:99:89:B0:A5:0C:4E:6B:04:B8';

test('the statement covers every configured app', function () {
    config()->set('services.native_auth.android_apps', [
        ['package' => 'it.maicol07.gamerlogue.dev', 'fingerprints' => [DEBUG_FINGERPRINT]],
        ['package' => 'it.maicol07.gamerlogue', 'fingerprints' => ['AA:BB:CC']],
    ]);

    $response = $this->getJson('/.well-known/assetlinks.json')->assertOk();

    // Debug and release are different packages, so each needs its own statement: one statement
    // listing both fingerprints would verify neither.
    expect($response->json())->toHaveCount(2)
        ->and($response->json('0.target.package_name'))->toBe('it.maicol07.gamerlogue.dev')
        ->and($response->json('0.target.sha256_cert_fingerprints.0'))->toBe(DEBUG_FINGERPRINT)
        ->and($response->json('1.target.package_name'))->toBe('it.maicol07.gamerlogue')
        ->and($response->json('0.relation.0'))->toBe('delegate_permission/common.handle_all_urls')
        ->and($response->json('0.target.namespace'))->toBe('android_app');
});

test('an unconfigured app serves nothing', function () {
    config()->set('services.native_auth.android_apps', []);

    $this->getJson('/.well-known/assetlinks.json')->assertNotFound();
});
