<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;

/**
 * Someone did something to a user's profile or content. Stored in the database only; its `type`
 * column holds the kind (review_liked, comment_replied…) rather than the class name.
 */
class SocialNotification extends Notification
{
    /**
     * @param  array<string, mixed>  $extra  e.g. game_id, comment_id, reaction
     */
    public function __construct(
        public readonly string $type,
        public readonly User $actor,
        public readonly ?Model $subject,
        public readonly array $extra,
    ) {}

    /**
     * Sends it unless the recipient is the actor, or the two are in a block.
     *
     * @param  array<string, mixed>  $extra
     */
    public static function send(User $recipient, string $type, User $actor, ?Model $subject, array $extra): void
    {
        if ($recipient->is($actor) || $recipient->isBlockedWith($actor)) {
            return;
        }

        $recipient->notify(new self($type, $actor, $subject, $extra));
    }

    /**
     * @return list<string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function databaseType(object $notifiable): string
    {
        return $this->type;
    }

    /**
     * Enough to render without fetching anything: who, about what, and the IGDB game if any.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'actor' => ['id' => $this->actor->id, 'nickname' => $this->actor->nickname, 'picture' => $this->actor->picture],
            'subject_type' => $this->subject?->getMorphClass(),
            'subject_id' => $this->subject?->getKey(),
            ...$this->extra,
        ];
    }
}
