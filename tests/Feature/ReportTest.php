<?php

declare(strict_types=1);

use App\Enums\LibraryEntryStatus;
use App\Models\GameList;
use App\Models\LibraryEntry;
use App\Models\Report;
use App\Models\User;
use App\Models\UserBlock;

/**
 * @param  array<string, mixed>  $attributes
 * @return array<string, mixed>
 */
function reportDocument(array $attributes): array
{
    return ['data' => ['type' => 'Report', 'attributes' => $attributes]];
}

test('users and content can be reported', function () {
    $reporter = User::factory()->create();
    $target = User::factory()->create();
    $entry = LibraryEntry::create(['user_id' => $target->id, 'game_id' => 1, 'status' => LibraryEntryStatus::Playing, 'owned' => true]);
    $list = GameList::factory()->for($target)->create();

    foreach ([['user', $target->id], ['library_entry', (string) $entry->id], ['list', (string) $list->id]] as [$type, $id]) {
        actingAsNative($reporter)->postJson('/api/reports', reportDocument([
            'reportable_type' => $type, 'reportable_id' => $id, 'reason' => 'harassment', 'note' => 'Rude',
        ]), jsonApiHeaders())
            ->assertCreated()
            ->assertJsonPath('data.attributes.reason', 'harassment');
    }

    expect(Report::where('user_id', $reporter->id)->count())->toBe(3);
});

test('a blocked user can still be reported', function () {
    $victim = User::factory()->create();
    $abuser = User::factory()->create();
    UserBlock::create(['user_id' => $abuser->id, 'blocked_id' => $victim->id]);

    actingAsNative($victim)->postJson('/api/reports', reportDocument([
        'reportable_type' => 'user', 'reportable_id' => $abuser->id, 'reason' => 'harassment',
    ]), jsonApiHeaders())->assertCreated();
});

test('reports are validated', function (array $attributes) {
    $reporter = User::factory()->create();
    $target = User::factory()->create();
    Report::forceCreate(['user_id' => $reporter->id, 'reportable_type' => 'user', 'reportable_id' => $target->id, 'reason' => 'spam']);
    $attributes = array_map(static fn ($value) => $value === 'TARGET' ? $target->id : $value, $attributes);

    actingAsNative($reporter)->postJson('/api/reports', reportDocument($attributes), jsonApiHeaders())
        ->assertUnprocessable();
})->with([
    'unknown type' => [['reportable_type' => 'game', 'reportable_id' => '1', 'reason' => 'spam']],
    'missing subject' => [['reportable_type' => 'list', 'reportable_id' => '999', 'reason' => 'spam']],
    'unknown reason' => [['reportable_type' => 'user', 'reportable_id' => 'TARGET', 'reason' => 'boring']],
    'already reported' => [['reportable_type' => 'user', 'reportable_id' => 'TARGET', 'reason' => 'other']],
    'note too long' => [['reportable_type' => 'list', 'reportable_id' => '1', 'reason' => 'other', 'note' => str_repeat('a', 1001)]],
]);

test('a report reads back only to its author', function () {
    $report = Report::forceCreate(['user_id' => User::factory()->create()->id, 'reportable_type' => 'user', 'reportable_id' => 'x', 'reason' => 'spam']);

    actingAsNative(User::factory()->create())->getJson("/api/reports/{$report->id}", jsonApiHeaders())->assertNotFound();
});
