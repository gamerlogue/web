<?php

declare(strict_types=1);

test('the asset links statement is public and describes the configured app', function () {
    config()->set('services.native_auth.android_package', 'it.maicol07.gamerlogue');
    config()->set('services.native_auth.android_fingerprints', ['AA:BB:CC']);

    $this->getJson('/.well-known/assetlinks.json')
        ->assertOk()
        ->assertJsonPath('0.target.package_name', 'it.maicol07.gamerlogue')
        ->assertJsonPath('0.target.namespace', 'android_app')
        ->assertJsonPath('0.relation.0', 'delegate_permission/common.handle_all_urls');
});

test('an unconfigured app serves nothing', function () {
    config()->set('services.native_auth.android_package', null);
    config()->set('services.native_auth.android_fingerprints', []);

    $this->getJson('/.well-known/assetlinks.json')->assertNotFound();
});
