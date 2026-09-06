<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Notifications\RefreshTokenReuseAlert;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Reiarseni\SanctumRefreshToken\Events\RefreshTokenReuseDetected;

class ReportRefreshTokenReuse
{
    /**
     * Handle a replayed refresh token synchronously so the request IP is captured.
     */
    public function handle(RefreshTokenReuseDetected $event): void
    {
        $userId = (string) $event->tokenable->getKey();
        $ip = request()->ip();

        Log::warning('Refresh token reuse detected', [
            'user_id' => $userId,
            'family_uuid' => $event->familyUuid,
            'ip' => $ip,
            'replayed_generation' => $event->replayedGeneration,
            'current_generation' => $event->currentGeneration,
            'seconds_since_rotation' => $event->secondsSinceRotation,
        ]);

        $adminEmail = config('app.admin_email');

        if (! is_string($adminEmail) || $adminEmail === '') {
            return;
        }

        if (! Cache::add("refresh-token-reuse-alert:$userId", true, now()->addMinutes(5))) {
            return;
        }

        Notification::route('mail', $adminEmail)
            ->notify(new RefreshTokenReuseAlert($userId, $event->familyUuid, $ip));
    }
}
