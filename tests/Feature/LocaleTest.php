<?php

declare(strict_types=1);

test('stores supported locales in the session', function () {
    $this->patchJson('/set-locale', ['locale' => 'it'])
        ->assertOk()
        ->assertJsonPath('locale', 'it');

    $this->assertSame('it', session('locale'));
});

test('rejects unsupported locales', function () {
    $this->patchJson('/set-locale', ['locale' => '../../invalid'])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('locale');

    $this->assertNull(session('locale'));
});
