<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

/**
 * Someone did something to a user's profile or content. Stored in the database, whose `type`
 * column holds the kind (review_liked, comment_replied…) rather than the class name, and pushed
 * to the recipient's devices through FCM.
 *
 * @phpstan-type SocialType 'new_follower'|'review_liked'|'review_commented'|'list_liked'|'list_commented'|'comment_replied'|'comment_reacted'|'mention'
 */
class SocialNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param  SocialType  $type
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
     * @param  SocialType  $type
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
     * FCM only for users with a device: resolving the channel needs the Firebase credentials, and
     * a user without devices would only queue a job that does nothing.
     *
     * @return list<string>
     */
    public function via(object $notifiable): array
    {
        return $notifiable->routeNotificationFor('fcm', $this) === [] ? ['database'] : ['database', FcmChannel::class];
    }

    /**
     * Only the push is queued: the database row must exist when the request that caused it
     * returns.
     *
     * @return array<string, string>
     */
    public function viaConnections(): array
    {
        return ['database' => 'sync'];
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

    /**
     * Shown by Android even when the app is not running. English only: users have no stored locale.
     */
    public function toFcm(object $notifiable): FcmMessage
    {
        $actor = $this->actor->nickname;
        [$title, $body] = match ($this->type) {
            'new_follower' => ['New follower', "{$actor} started following you"],
            'review_liked' => ['New like', "{$actor} liked your review"],
            'review_commented' => ['New comment', "{$actor} commented on your review"],
            'list_liked' => ['New like', "{$actor} liked your list {$this->extra['list_name']}"],
            'list_commented' => ['New comment', "{$actor} commented on your list {$this->extra['list_name']}"],
            'comment_replied' => ['New reply', "{$actor} replied to your comment"],
            'comment_reacted' => ['New reaction', "{$actor} reacted to your comment"],
            'mention' => ['New mention', "{$actor} mentioned you in a comment"],
        };
        // Must match the app's NotificationChannel.ofNotificationType.
        $channel = match ($this->type) {
            'new_follower' => 'followers',
            'mention' => 'mentions',
            default => 'social',
        };

        return FcmMessage::create()
            ->notification(new FcmNotification(title: $title, body: $body))
            ->data(['notification_id' => $this->id, 'type' => $this->type])
            ->android(['notification' => ['channel_id' => $channel]]);
    }
}
