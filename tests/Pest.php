<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

pest()->extend(TestCase::class)->use(RefreshDatabase::class)->in('Feature', 'Unit');

/**
 * Authenticates as a native client would: a Sanctum token carrying the abilities
 * SanctumTokenController issues, rather than a session. Sanctum::actingAs() returns the user,
 * so it cannot be chained onto a request directly.
 *
 * @param  string[]  $abilities
 * @return TestCase Pest wraps it in a HigherOrderTapProxy, hence no declared return type.
 */
function actingAsNative(User $user, array $abilities = ['library', 'profile'])
{
    Sanctum::actingAs($user, $abilities);

    return test();
}
