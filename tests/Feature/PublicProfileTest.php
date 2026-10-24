<?php

declare(strict_types=1);

use App\Enums\LibraryEntryStatus;
use App\Enums\Visibility;
use App\Models\LibraryEntry;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\TestResponse;
use Maicol07\OIDCClient\Models\OidcAuthMapping;
use Maicol07\OpenIDConnect\UserInfo;

/**
 * @param  array<string, mixed>  $attributes
 */
function patchProfile(User $user, array $attributes): TestResponse
{
    return actingAsNative($user)->json('PATCH', "/api/users/{$user->id}", [
        'data' => ['type' => 'User', 'id' => $user->id, 'attributes' => $attributes],
    ], jsonApiHeaders());
}

/**
 * @param  array<string, mixed>  $attributes
 */
function libraryEntryFor(User $user, int $gameId, array $attributes = []): LibraryEntry
{
    return LibraryEntry::create([
        'user_id' => $user->id,
        'game_id' => $gameId,
        'status' => LibraryEntryStatus::Playing,
        'owned' => true,
        ...$attributes,
    ]);
}

const PUBLIC_CARD = ['nickname', 'name', 'picture', 'visibility'];

test('a public profile shows its fields but never the account data', function () {
    config(['services.oidc.picture_edit_url' => 'https://idp.example.test/profile']);
    $owner = User::factory()->create([
        'email' => 'owner@example.test',
        'picture' => 'https://example.test/me.png',
        'bio' => 'Hi',
        'banner_game_id' => 7,
        'banner_image_id' => 'abc',
        'platforms_ids' => [6, 48],
    ]);

    actingAsNative(User::factory()->create())
        ->getJson("/api/users/{$owner->id}", jsonApiHeaders())
        ->assertOk()
        ->assertJsonPath('data.attributes.bio', 'Hi')
        ->assertJsonPath('data.attributes.banner_game_id', 7)
        ->assertJsonPath('data.attributes.banner_image_id', 'abc')
        ->assertJsonPath('data.attributes.platforms_ids', [6, 48])
        ->assertJsonPath('data.attributes.visibility', 'public')
        ->assertJsonMissingPath('data.attributes.email')
        ->assertJsonMissingPath('data.attributes.email_verified_at')
        ->assertJsonMissingPath('data.attributes.picture_edit_url');

    actingAsNative($owner)
        ->getJson("/api/users/{$owner->id}", jsonApiHeaders())
        ->assertOk()
        ->assertJsonPath('data.attributes.email', 'owner@example.test')
        ->assertJsonPath('data.attributes.picture_edit_url', 'https://idp.example.test/profile');
});

test('a private profile shows others only its public card', function () {
    $owner = User::factory()->create([
        'visibility' => Visibility::Private,
        'picture' => 'https://example.test/me.png',
        'bio' => 'Hidden',
        'platforms_ids' => [6],
    ]);

    $attributes = actingAsNative(User::factory()->create())
        ->getJson("/api/users/{$owner->id}", jsonApiHeaders())
        ->assertOk()
        ->assertJsonPath('data.id', $owner->id)
        ->json('data.attributes');

    expect(array_keys($attributes))->toEqualCanonicalizing(PUBLIC_CARD);

    actingAsNative($owner)
        ->getJson("/api/users/{$owner->id}", jsonApiHeaders())
        ->assertOk()
        ->assertJsonPath('data.attributes.bio', 'Hidden')
        ->assertJsonPath('data.attributes.platforms_ids', [6]);
});

test('the user included in library entries follows the same rules', function () {
    $owner = User::factory()->create(['email' => 'owner@example.test']);
    libraryEntryFor($owner, 1);

    $included = actingAsNative(User::factory()->create())
        ->getJson("/api/library_entries?filter[user]={$owner->id}&include=user", jsonApiHeaders())
        ->assertOk()
        ->json('included');

    expect($included)->toHaveCount(1)
        ->and($included[0]['id'])->toBe($owner->id)
        ->and($included[0]['attributes'])->not->toHaveKey('email')
        ->and($included[0]['attributes'])->toHaveKey('first_name');

    actingAsNative($owner)
        ->getJson('/api/library_entries?include=user', jsonApiHeaders())
        ->assertOk()
        ->assertJsonPath('included.0.attributes.email', 'owner@example.test');
});

/**
 * Property security disables the serializer's per-class cache of allowed attributes. If it ever
 * stopped doing so, the second user in one response would inherit the first one's fields.
 */
test('each user in one response gets their own visibility', function () {
    $me = User::factory()->create(['nickname' => 'same_me', 'email' => 'me@example.test']);
    $other = User::factory()->create(['nickname' => 'same_other', 'email' => 'other@example.test', 'picture' => 'https://example.test/o.png', 'visibility' => Visibility::Private]);

    $users = collect(actingAsNative($me)
        ->getJson('/api/users?filter[search]=same_&sort=nickname', jsonApiHeaders())
        ->assertOk()
        ->json('data'))->keyBy('id');

    expect($users[$me->id]['attributes']['email'])->toBe('me@example.test')
        ->and(array_keys($users[$other->id]['attributes']))->toEqualCanonicalizing(PUBLIC_CARD);
});

test('the owner edits their profile', function () {
    $user = User::factory()->create();

    patchProfile($user, [
        'bio' => 'About me',
        'banner_game_id' => 12,
        'banner_image_id' => 'sc6xyz',
        'platforms_ids' => [48, 6],
        'visibility' => 'private',
    ])->assertOk();

    $user->refresh();
    expect($user->bio)->toBe('About me')
        ->and($user->banner_game_id)->toBe(12)
        ->and($user->banner_image_id)->toBe('sc6xyz')
        ->and($user->platforms_ids)->toBe([48, 6])
        ->and($user->visibility)->toBe(Visibility::Private);

    patchProfile($user, ['banner_game_id' => null, 'banner_image_id' => null])->assertOk();
    expect($user->refresh()->banner_game_id)->toBeNull();
});

test('profile fields are validated', function (array $attributes) {
    $user = User::factory()->create(['banner_game_id' => 1, 'banner_image_id' => 'abc']);
    User::factory()->create(['nickname' => 'Taken']);

    patchProfile($user, $attributes)->assertUnprocessable();
})->with([
    'bio too long' => [['bio' => str_repeat('a', 501)]],
    'banner game without image' => [['banner_image_id' => null]],
    'banner image without game' => [['banner_game_id' => null]],
    'game id not positive' => [['banner_game_id' => 0, 'banner_image_id' => 'x']],
    'duplicate platform' => [['platforms_ids' => [6, 6]]],
    'non integer platform' => [['platforms_ids' => ['6']]],
    'unknown visibility' => [['visibility' => 'friends']],
    'nickname taken in another case' => [['nickname' => 'taken']],
    'nickname too short' => [['nickname' => 'ab']],
    'nickname with spaces' => [['nickname' => 'two words']],
]);

test('a nickname may use any letter and be resubmitted even if it predates the rules', function () {
    $user = User::factory()->create(['nickname' => 'legacy name']);

    patchProfile($user, ['nickname' => 'legacy name', 'bio' => 'x'])->assertOk();
    patchProfile($user, ['nickname' => 'Àlex_2.0'])->assertOk();

    expect($user->refresh()->nickname)->toBe('Àlex_2.0');
});

test('the identity provider only seeds a free nickname', function () {
    User::factory()->create(['nickname' => 'Ada']);
    $info = new UserInfo(collect(['nickname' => 'ada', 'email_verified' => true]));

    $newcomer = new User;
    $newcomer->mapOIDCUserinfo('https://issuer.example.test', $info, new OidcAuthMapping);
    $renamed = new User(['nickname' => 'mine']);
    $renamed->mapOIDCUserinfo('https://issuer.example.test', new UserInfo(collect(['nickname' => 'fresh'])), new OidcAuthMapping);

    expect($newcomer->nickname)->toBeNull()
        ->and($renamed->nickname)->toBe('mine');
});

test('users are searched by nickname or name', function () {
    $me = User::factory()->create(['nickname' => 'me', 'first_name' => 'Zed', 'last_name' => null]);
    $mario = User::factory()->create(['nickname' => 'plumber', 'first_name' => 'Mario', 'last_name' => 'Rossi']);
    User::factory()->create(['nickname' => 'luigi_100', 'first_name' => 'Luigi', 'last_name' => 'Verdi']);
    $private = User::factory()->create(['nickname' => 'luigi_private', 'first_name' => 'X', 'last_name' => 'Y', 'visibility' => Visibility::Private]);

    $search = fn (string $term) => collect(actingAsNative($me)
        ->getJson('/api/users?filter[search]=' . urlencode($term), jsonApiHeaders())
        ->assertOk()
        ->assertJsonStructure(['meta' => ['totalItems']])
        ->json('data'))->pluck('id')->all();

    expect($search('mario ros'))->toBe([$mario->id])
        ->and($search('PLUMB'))->toBe([$mario->id])
        ->and($search('luigi_'))->toHaveCount(2)->toContain($private->id)
        ->and($search('%'))->toBe([]);

    // No search: still the current-user endpoint.
    actingAsNative($me)->getJson('/api/users', jsonApiHeaders())
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.id', $me->id);
});

test('another users library is readable unless the profile is private', function () {
    $public = User::factory()->create();
    $private = User::factory()->create(['visibility' => Visibility::Private]);
    $viewer = User::factory()->create();
    libraryEntryFor($public, 1);
    libraryEntryFor($private, 2);
    libraryEntryFor($viewer, 3);

    actingAsNative($viewer)
        ->getJson("/api/library_entries?filter[user]={$public->id}", jsonApiHeaders())
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.attributes.game_id', 1);

    actingAsNative($viewer)
        ->getJson("/api/library_entries?filter[user]={$private->id}", jsonApiHeaders())
        ->assertForbidden()
        ->assertJsonPath('errors.0.code', 'profile_private');

    actingAsNative($private)
        ->getJson("/api/library_entries?filter[user]={$private->id}", jsonApiHeaders())
        ->assertOk()
        ->assertJsonCount(1, 'data');

    // current_user=true keeps meaning the caller, whatever else is asked.
    actingAsNative($viewer)
        ->getJson("/api/library_entries?current_user=true&filter[user]={$public->id}", jsonApiHeaders())
        ->assertOk()
        ->assertJsonPath('data.0.attributes.game_id', 3);

    actingAsNative($viewer)
        ->getJson('/api/library_entries?filter[user]=not-a-uuid', jsonApiHeaders())
        ->assertUnprocessable();
});

test('someone elses entries stay read only', function () {
    $owner = User::factory()->create();
    $entry = libraryEntryFor($owner, 1);

    actingAsNative(User::factory()->create())
        ->json('PATCH', "/api/library_entries/{$entry->id}?filter[user]={$owner->id}", [
            'data' => ['type' => 'LibraryEntry', 'attributes' => ['rating' => 1]],
        ], jsonApiHeaders())
        ->assertNotFound();
});

test('entries are filtered by whether they have a review', function () {
    $user = User::factory()->create();
    libraryEntryFor($user, 1, ['review' => 'Great']);
    libraryEntryFor($user, 2, ['review' => '']);
    libraryEntryFor($user, 3);
    libraryEntryFor($user, 4, ['rating_details' => ['story' => ['rating' => 80, 'review' => '']]]);
    libraryEntryFor($user, 5, ['rating' => 60]);

    $gameIds = fn (string $value) => collect(actingAsNative($user)
        ->getJson("/api/library_entries?filter[has_review]=$value", jsonApiHeaders())
        ->assertOk()
        ->json('data'))->pluck('attributes.game_id')->all();

    expect($gameIds('true'))->toEqualCanonicalizing([1, 4, 5])
        ->and($gameIds('false'))->toEqualCanonicalizing([2, 3]);

    actingAsNative($user)
        ->getJson('/api/library_entries?filter[has_review]=maybe', jsonApiHeaders())
        ->assertUnprocessable();
});

test('review_updated_at follows the review text only and cannot be written', function () {
    $user = User::factory()->create();
    $this->travelTo('2026-01-01 10:00:00');

    $id = actingAsNative($user)->postJson('/api/library_entries', [
        'data' => ['type' => 'LibraryEntry', 'attributes' => [
            'game_id' => 1, 'status' => 'PLAYING', 'owned' => true, 'review' => null,
            'review_updated_at' => '2000-01-01T00:00:00+00:00',
        ]],
    ], jsonApiHeaders())->assertCreated()
        ->assertJsonPath('data.attributes.review_spoiler', false)
        ->json('data.id');
    $entry = LibraryEntry::findOrFail($id);
    expect($entry->review_updated_at)->toBeNull();

    $patch = fn (array $attributes) => actingAsNative($user)->json('PATCH', "/api/library_entries/{$id}", [
        'data' => ['type' => 'LibraryEntry', 'attributes' => $attributes],
    ], jsonApiHeaders())->assertOk();

    $patch(['review' => '']);
    expect($entry->refresh()->review_updated_at)->toBeNull();

    $this->travelTo('2026-01-02 10:00:00');
    $patch(['review' => 'Loved it', 'review_spoiler' => true]);
    expect($entry->refresh()->review_updated_at->toDateString())->toBe('2026-01-02')
        ->and($entry->review_spoiler)->toBeTrue();

    $this->travelTo('2026-01-03 10:00:00');
    $patch(['rating' => 80, 'review_spoiler' => false]);
    expect($entry->refresh()->review_updated_at->toDateString())->toBe('2026-01-02');
});

test('entries can be sorted by review date', function () {
    $user = User::factory()->create();
    $this->travelTo('2026-01-01');
    libraryEntryFor($user, 1, ['review' => 'old']);
    $this->travelTo('2026-02-01');
    libraryEntryFor($user, 2, ['review' => 'new']);

    expect(collect(actingAsNative($user)
        ->getJson('/api/library_entries?sort=-review_updated_at', jsonApiHeaders())
        ->assertOk()
        ->json('data'))->pluck('attributes.game_id')->all())->toBe([2, 1]);
});

test('the included owner of library entries is loaded once', function () {
    $user = User::factory()->create();
    foreach (range(1, 10) as $gameId) {
        libraryEntryFor($user, $gameId);
    }

    DB::enableQueryLog();
    actingAsNative($user)->getJson('/api/library_entries?include=user', jsonApiHeaders())->assertOk();

    // Constant: the caller's blocks (2), the count, the page and its owner.
    expect(count(DB::getQueryLog()))->toBeLessThan(6);
});

test('picture is the provider URL, else the email Gravatar, else null', function (?string $picture, string $email, ?string $expected) {
    $owner = User::factory()->create(['visibility' => Visibility::Private, 'picture' => $picture, 'email' => $email]);

    $attributes = actingAsNative(User::factory()->create())
        ->getJson("/api/users/{$owner->id}", jsonApiHeaders())
        ->assertOk()
        ->assertJsonMissingPath('data.attributes.email')
        ->json('data.attributes');

    expect($attributes['picture'] ?? null)->toBe($expected);
})->with([
    'provider URL' => ['https://example.test/me.png', 'me@example.test', 'https://example.test/me.png'],
    'gravatar with email' => ['gravatar', '  Me@Example.TEST ', 'https://gravatar.com/avatar/' . hash('sha256', 'me@example.test') . '?d=404'],
    'no email' => ['gravatar', '', null],
]);
