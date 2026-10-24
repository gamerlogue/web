<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\LibraryEntryCompletionStatus;
use App\Enums\LibraryEntryStatus;
use App\Models\LibraryEntry;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Library statistics of a profile, as plain JSON: a computed summary, not a resource.
 */
class ProfileStatsController
{
    public function __invoke(Request $request, User $user): JsonResponse
    {
        abort_unless($request->user()?->tokenCan('library'), 403);
        $user->ensureProfileVisibleTo($request->user());
        $year = $request->validate(['year' => ['sometimes', 'integer', 'between:1900,9999']])['year'] ?? null;
        $year = $year === null ? null : (int) $year;

        // Arrays only: config/cache.php refuses to unserialize objects.
        $stats = Cache::remember(
            'profile_stats:' . $user->id . ':' . LibraryEntry::statsVersion($user->id) . ':' . ($year ?? 'all'),
            now()->addDay(),
            fn (): array => $this->calculate($user->id, $year),
        );

        // Year => count maps stay JSON objects even when empty or when the keys look like a list.
        $stats['completed_by_year'] = (object) $stats['completed_by_year'];
        $stats['started_by_year'] = (object) $stats['started_by_year'];

        return response()->json($stats);
    }

    /**
     * @return array<string, mixed>
     */
    private function calculate(string $userId, ?int $year): array
    {
        $query = LibraryEntry::where('user_id', $userId);
        if ($year !== null) {
            // An entry belongs to the year it ended, else the one it started, else the one it was added.
            $query->whereRaw('COALESCE(end_date, start_date, created_at) BETWEEN ? AND ?', ["$year-01-01", "$year-12-31 23:59:59"]);
        }

        $stats = [
            'status_counts' => array_fill_keys(array_column(LibraryEntryStatus::cases(), 'value'), 0),
            'completion_status_counts' => array_fill_keys(array_column(LibraryEntryCompletionStatus::cases(), 'value'), 0),
            'owned_count' => 0,
            'total_played_time' => 0,
            'average_rating' => null,
            'rating_histogram' => array_fill(0, 11, 0),
            'platforms' => [],
            'completed_by_year' => [],
            'started_by_year' => [],
            'reviews_count' => 0,
        ];
        $ratings = [];

        foreach ($query->cursor() as $entry) {
            $stats['status_counts'][$entry->status->value]++;
            if ($entry->completion_status !== null) {
                $stats['completion_status_counts'][$entry->completion_status->value]++;
            }
            $stats['owned_count'] += (int) $entry->owned;
            $stats['total_played_time'] += $entry->played_time ?? 0;
            if ($entry->rating !== null) {
                $ratings[] = $entry->rating;
                // Ratings run 0-100: bucket N holds [10N, 10N+10), and 100 sits in bucket 10.
                $stats['rating_histogram'][intdiv((int) $entry->rating, 10)]++;
            }
            foreach (array_unique($entry->platforms_ids ?? []) as $platformId) {
                $stats['platforms'][$platformId] ??= ['platform_id' => (int) $platformId, 'entries_count' => 0, 'played_time' => 0];
                $stats['platforms'][$platformId]['entries_count']++;
                $stats['platforms'][$platformId]['played_time'] += $entry->played_time ?? 0;
            }
            if ($entry->status === LibraryEntryStatus::Completed && $entry->end_date !== null) {
                $stats['completed_by_year'][$entry->end_date->year] = ($stats['completed_by_year'][$entry->end_date->year] ?? 0) + 1;
            }
            if ($entry->start_date !== null) {
                $stats['started_by_year'][$entry->start_date->year] = ($stats['started_by_year'][$entry->start_date->year] ?? 0) + 1;
            }
            $stats['reviews_count'] += (int) $entry->hasReview();
        }

        $stats['average_rating'] = $ratings === [] ? null : round(array_sum($ratings) / count($ratings), 2);
        ksort($stats['platforms']);
        $stats['platforms'] = array_values($stats['platforms']);
        ksort($stats['completed_by_year']);
        ksort($stats['started_by_year']);

        return $stats;
    }
}
