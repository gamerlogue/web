<?php

declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Reiarseni\SanctumRefreshToken\Events\TokenFamilyRevoked;

class LogTokenFamilyRevocation
{
    public function handle(TokenFamilyRevoked $event): void
    {
        Log::info('Token family revoked', [
            'user_id' => $event->tokenable->getKey(),
            'family_uuid' => $event->familyUuid,
            'reason' => $event->reason->value,
            'ip' => request()->ip(),
        ]);
    }
}
