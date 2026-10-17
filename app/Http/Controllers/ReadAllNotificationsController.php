<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Marks every notification of the caller as read. A bulk action, which JSON:API cannot express.
 */
class ReadAllNotificationsController
{
    public function __invoke(Request $request): Response
    {
        abort_unless($request->user()?->tokenCan('profile'), 403);
        $request->user()->unreadNotifications()->update(['read_at' => now()]);

        return response()->noContent();
    }
}
