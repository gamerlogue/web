<?php

declare(strict_types=1);

use App\Enums\LibraryEntryCompletionStatus;
use App\Enums\LibraryEntryStatus;
use App\Enums\Visibility;
use App\Models\LibraryEntry;
use App\Models\User;

beforeEach(function () {
    $this->owner = User::factory()->create();
    foreach ([
        [1, LibraryEntryStatus::Completed, LibraryEntryCompletionStatus::MainStory, true, '2025-12-20', '2026-01-05', 95, 30, [6, 48], 'Great'],
        [2, LibraryEntryStatus::Completed, LibraryEntryCompletionStatus::Full100, false, '2024-03-01', '2024-04-01', 100, 50, [6], ''],
        [3, LibraryEntryStatus::Playing, null, true, '2026-02-01', null, 42.5, 10, [48, 48], null],
        [4, LibraryEntryStatus::Backlog, null, false, null, null, null, null, [], 'Meh'],
    ] as [$gameId, $status, $completion, $owned, $start, $end, $rating, $playedTime, $platforms, $review]) {
        LibraryEntry::create([
            'user_id' => $this->owner->id, 'game_id' => $gameId, 'status' => $status,
            'completion_status' => $completion, 'owned' => $owned, 'start_date' => $start,
            'end_date' => $end, 'rating' => $rating, 'played_time' => $playedTime,
            'platforms_ids' => $platforms, 'review' => $review,
        ]);
    }
});

test('statistics summarise the whole library', function () {
    $stats = actingAsNative(User::factory()->create())
        ->getJson("/api/users/{$this->owner->id}/stats")
        ->assertOk()
        ->json();

    expect($stats['status_counts'])->toMatchArray(['COMPLETED' => 2, 'PLAYING' => 1, 'BACKLOG' => 1, 'PAUSED' => 0])
        ->and($stats['completion_status_counts'])->toMatchArray(['MAIN_STORY' => 1, 'FULL_100' => 1])
        ->and($stats['owned_count'])->toBe(2)
        ->and($stats['total_played_time'])->toBe(90)
        ->and($stats['average_rating'])->toEqual(79.17)
        ->and($stats['rating_histogram'])->toBe([0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1])
        ->and($stats['platforms'])->toBe([
            ['platform_id' => 6, 'entries_count' => 2, 'played_time' => 80],
            ['platform_id' => 48, 'entries_count' => 2, 'played_time' => 40],
        ])
        ->and($stats['completed_by_year'])->toBe(['2024' => 1, '2026' => 1])
        ->and($stats['started_by_year'])->toBe(['2024' => 1, '2025' => 1, '2026' => 1])
        ->and($stats['reviews_count'])->toBe(2);
});

test('statistics can be limited to a year', function () {
    $stats = actingAsNative($this->owner)
        ->getJson("/api/users/{$this->owner->id}/stats?year=2026")
        ->assertOk()
        ->json();

    // Games 1 (ended in 2026), 3 (started in 2026) and 4 (no dates, added now: 2026).
    expect(array_sum($stats['status_counts']))->toBe(3)
        ->and($stats['completed_by_year'])->toBe(['2026' => 1]);

    actingAsNative($this->owner)
        ->getJson("/api/users/{$this->owner->id}/stats?year=26")
        ->assertUnprocessable();
});

test('statistics are cached until the library changes', function () {
    $count = fn () => actingAsNative($this->owner)
        ->getJson("/api/users/{$this->owner->id}/stats?year=2026")
        ->json('status_counts.PLAYING');

    expect($count())->toBe(1);

    // A bulk query skips model events, so the cached figures survive it.
    LibraryEntry::where('game_id', 4)->update(['status' => LibraryEntryStatus::Playing]);
    expect($count())->toBe(1);

    LibraryEntry::where('game_id', 1)->firstOrFail()->update(['status' => LibraryEntryStatus::Playing]);
    expect($count())->toBe(3);

    LibraryEntry::where('game_id', 3)->firstOrFail()->delete();
    expect($count())->toBe(2);
});

test('statistics of a private profile are forbidden to others', function () {
    $this->owner->update(['visibility' => Visibility::Private]);

    actingAsNative(User::factory()->create())
        ->getJson("/api/users/{$this->owner->id}/stats")
        ->assertForbidden()
        ->assertJsonPath('errors.0.code', 'profile_private');

    actingAsNative($this->owner)
        ->getJson("/api/users/{$this->owner->id}/stats")
        ->assertOk();
});

test('statistics need the library ability', function () {
    actingAsNative($this->owner, ['profile'])
        ->getJson("/api/users/{$this->owner->id}/stats")
        ->assertForbidden();
});

test('statistics need authentication', function () {
    $this->getJson("/api/users/{$this->owner->id}/stats")->assertUnauthorized();
});
