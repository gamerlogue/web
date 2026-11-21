<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\DeviceToken;
use Illuminate\Notifications\Events\NotificationFailed;
use Kreait\Firebase\Messaging\SendReport;
use NotificationChannels\Fcm\FcmChannel;

/**
 * Forgets a token FCM will never deliver to again (UNREGISTERED, or INVALID_ARGUMENT about the
 * token). Any other failure is left to the queue's retries.
 */
class DeleteInvalidDeviceToken
{
    public function handle(NotificationFailed $event): void
    {
        $report = $event->data['report'] ?? null;
        if ($event->channel !== FcmChannel::class || ! $report instanceof SendReport) {
            return;
        }

        if ($report->messageWasSentToUnknownToken() || $report->messageTargetWasInvalid()) {
            DeviceToken::where('token', $report->target()->value())->delete();
        }
    }
}
