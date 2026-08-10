<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Gate;

test('admin gates only allow the configured admin', function (string $gate) {
    config()->set('app.admin_email', 'admin@example.test');

    $admin = User::factory()->create(['email' => 'admin@example.test']);
    $other = User::factory()->create();

    expect(Gate::forUser($admin)->allows($gate))->toBeTrue()
        ->and(Gate::forUser($other)->allows($gate))->toBeFalse()
        ->and(Gate::forUser(null)->allows($gate))->toBeFalse();
})->with(['admin', 'viewTelescope', 'viewHorizon']);

test('an empty admin email locks everyone out', function (string $gate) {
    config()->set('app.admin_email', '');

    $user = User::factory()->create(['email' => '']);

    expect(Gate::forUser($user)->allows($gate))->toBeFalse()
        ->and(Gate::forUser(null)->allows($gate))->toBeFalse();
})->with(['admin', 'viewTelescope', 'viewHorizon']);
