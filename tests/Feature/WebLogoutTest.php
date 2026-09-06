<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\SessionGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

test('the web client signs out with a POST and gets no content back', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertNoContent();

    expect(auth()->guard('web')->check())->toBeFalse();
});

test('the session behind the cookie stops resolving', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $sessionId = session()->getId();
    $token = session()->token();

    $this->post(route('logout'))->assertNoContent();

    // invalidate() rotates the id and regenerateToken() rotates the XSRF value, so the pair the
    // client still holds in its cookies authenticates nothing.
    expect(session()->getId())->not->toBe($sessionId)
        ->and(session()->token())->not->toBe($token)
        ->and(session()->has('login_web_' . sha1(SessionGuard::class)))->toBeFalse();
});

/** A sign-out a client cannot retry is a sign-out that leaves the client stuck. */
test('signing out twice is not an error', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('logout'))
        ->assertNoContent();

    $this->post(route('logout'))->assertNoContent();
});

test('a guest signing out is answered rather than sent through OIDC', function () {
    $this->post(route('logout'))->assertNoContent();
});

/**
 * The reason this exists rather than the OIDC package's GET: a navigable logout can be triggered
 * from any page the user visits. This one is not navigable and sits in the web group, so the CSRF
 * middleware sees it — which the test suite itself cannot assert, since VerifyCsrfToken skips
 * while running unit tests.
 */
test('the sign-out is not navigable and stays inside the web group', function () {
    $this->get('/logout')->assertMethodNotAllowed();

    expect(Route::getRoutes()->getByName('logout')->gatherMiddleware())->toContain('web');
});
