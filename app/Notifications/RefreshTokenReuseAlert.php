<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * A replayed refresh token means someone holds a credential they should not, or a device was
 * cloned. The log line records it; this is what makes someone read the log line.
 *
 * Queued: the request that detected the reuse has already been refused and should not wait on
 * SMTP. Everything the mail needs is carried as data, because a queued job has no request.
 */
class RefreshTokenReuseAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $userId,
        private readonly string $familyUuid,
        private readonly ?string $ip,
    ) {}

    /** @return list<string> */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Refresh token reuse detected')
            ->line('A consumed refresh token was replayed outside the grace window. The token family has been revoked and the session is over.')
            ->line("User: {$this->userId}")
            ->line("Family: {$this->familyUuid}")
            ->line('Client address: ' . ($this->ip ?? 'unknown'))
            ->line('Run `sanctum-refresh:doctor` for the mortality breakdown over the last week.');
    }
}
