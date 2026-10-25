<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Carbon;
use Maicol07\OIDCClient\Models\OidcAuthMapping;
use Maicol07\OpenIDConnect\UserInfo;

function userInfo(bool $emailVerified): UserInfo
{
    return new UserInfo(collect([
        'given_name' => 'Ada',
        'family_name' => 'Lovelace',
        'nickname' => 'ada',
        'picture' => 'https://example.test/ada.png',
        'email' => 'ada@example.test',
        'email_verified' => $emailVerified,
    ]));
}

test('a verified OIDC user gets a Carbon verification timestamp', function () {
    $user = new User;

    $user->mapOIDCUserinfo('https://issuer.example.test', userInfo(true), new OidcAuthMapping);

    expect($user->email_verified_at)->toBeInstanceOf(Carbon::class)
        ->and($user->email)->toBe('ada@example.test')
        ->and($user->name)->toBe('Ada Lovelace');
});

test('an unverified OIDC user has no verification timestamp', function () {
    $user = new User;

    $user->mapOIDCUserinfo('https://issuer.example.test', userInfo(false), new OidcAuthMapping);

    expect($user->email_verified_at)->toBeNull();
});

test('OIDC mapping accepts a missing nickname claim', function () {
    $user = new User;
    $info = userInfo(true);
    $info->attrs()->forget('nickname');

    $user->mapOIDCUserinfo('https://issuer.example.test', $info, new OidcAuthMapping);

    expect($user->nickname)->toBeNull()
        ->and($user->email_verified_at)->toBeInstanceOf(Carbon::class);
});
