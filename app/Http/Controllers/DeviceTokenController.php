<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\DeviceToken;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Registers the caller's FCM token. Sent on every app start and token rotation, so it upserts by
 * token: a token last registered by someone else moves to the caller.
 */
class DeviceTokenController
{
    public function __invoke(Request $request): Response
    {
        abort_unless($request->user()?->tokenCan('profile'), 403);
        $validated = $request->validate([
            'token' => ['required', 'string', 'max:4096'],
            'platform' => ['required', 'in:android'],
        ]);

        DeviceToken::upsert([['user_id' => $request->user()->id, ...$validated]], ['token'], ['user_id', 'platform']);

        return response()->noContent();
    }
}
