<?php

declare(strict_types=1);

use App\Enums\LibraryEntryCompletionStatus;
use App\Enums\LibraryEntryStatus;
use App\Models\LibraryEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();

    $entries = [
        [1, LibraryEntryStatus::Playing, null, true, '2026-01-10', null, 6.5, 10],
        [2, LibraryEntryStatus::Completed, LibraryEntryCompletionStatus::Full100, false, '2026-03-01', '2026-04-01', 9.0, 80],
        [3, LibraryEntryStatus::Completed, LibraryEntryCompletionStatus::MainStory, true, '2026-05-20', '2026-06-15', 7.5, 40],
    ];

    foreach ($entries as [$gameId, $status, $completionStatus, $owned, $startDate, $endDate, $rating, $playedTime]) {
        LibraryEntry::create([
            'user_id' => $this->user->id,
            'game_id' => $gameId,
            'status' => $status,
            'completion_status' => $completionStatus,
            'owned' => $owned,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'rating' => $rating,
            'played_time' => $playedTime,
        ]);
    }
});

/**
 * @return list<int>
 */
function filteredGameIds(string $query): array
{
    return collect(
        actingAsNative(test()->user)
            ->getJson("/api/library_entries?$query", jsonApiHeaders())
            ->assertOk()
            ->json('data')
    )->pluck('attributes.game_id')->all();
}

test('entries can be filtered', function (string $query, array $expectedGameIds) {
    expect(filteredGameIds($query))->toEqualCanonicalizing($expectedGameIds);
})->with([
    'status' => ['filter[status]=COMPLETED', [2, 3]],
    'completion status' => ['filter[completion_status]=MAIN_STORY', [3]],
    'owned' => ['filter[owned]=false', [2]],
    'start date range' => ['filter[start_date][gte]=2026-03-01&filter[start_date][lt]=2026-05-20', [2]],
    'end date' => ['filter[end_date][eq]=2026-06-15', [3]],
    'rating range' => ['filter[rating][gt]=7', [2, 3]],
    'played time range' => ['filter[played_time][lte]=40', [1, 3]],
    'combined' => ['filter[status]=COMPLETED&filter[owned]=true', [3]],
]);

test('entries can be sorted', function (string $sort, array $expectedGameIds) {
    expect(filteredGameIds("sort=$sort"))->toBe($expectedGameIds);
})->with([
    'ascending' => ['played_time', [1, 3, 2]],
    'descending' => ['-rating', [2, 3, 1]],
    'a field that is not sortable is ignored' => ['review,-rating', [2, 3, 1]],
]);

/**
 * RangeFilter iterates the value as an operator => bound map and indexes its operator table with
 * each key, so anything else used to surface as a 500.
 */
test('malformed filters are rejected', function (string $query) {
    actingAsNative($this->user)
        ->getJson("/api/library_entries?$query", jsonApiHeaders())
        ->assertUnprocessable();
})->with([
    'unknown status' => ['filter[status]=NOPE'],
    'unknown completion status' => ['filter[completion_status]=NOPE'],
    'non-boolean owned' => ['filter[owned]=maybe'],
    'range without an operator' => ['filter[rating]=4'],
    'range with an unknown operator' => ['filter[played_time][foo]=1'],
]);
