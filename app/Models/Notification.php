<?php

declare(strict_types=1);

namespace App\Models;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\QueryParameter;
use App\Http\Requests\NotificationRequest;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
use Symfony\Component\TypeInfo\Type\BuiltinType;
use Symfony\Component\TypeInfo\TypeIdentifier;

/**
 * A Laravel database notification of the caller, as a resource.
 */
#[ApiResource(
    description: 'An in-app notification of the caller.',
    operations: [
        new GetCollection(order: ['created_at' => 'DESC', 'id' => 'DESC']),
        new Get,
        new Patch,
    ],
    rules: NotificationRequest::class
)]
#[ApiProperty(description: 'new_follower, review_liked, review_commented, list_liked, list_commented, comment_replied or comment_reacted.', property: 'type', writable: false)]
#[ApiProperty(description: 'What the notification renders from.', property: 'data', writable: false, nativeType: new BuiltinType(TypeIdentifier::ARRAY))]
#[ApiProperty(description: 'Whether it was read; set it to true or false.', property: 'is_read', nativeType: new BuiltinType(TypeIdentifier::BOOL))]
#[ApiProperty(property: 'read_at', writable: false)]
#[ApiProperty(property: 'notifiable', readable: false, writable: false)]
#[ApiProperty(property: 'notifiable_type', readable: false, writable: false)]
#[ApiProperty(property: 'notifiable_id', readable: false, writable: false)]
#[QueryParameter('filter[unread]', description: 'Only unread (true) or read (false) notifications; meta.totalItems is then the count', constraints: ['in:true,false'])]
class Notification extends DatabaseNotification
{
    protected $hidden = ['id', 'notifiable_type', 'notifiable_id'];

    /**
     * Deletes the notifications about a subject, or about a comment that went with it.
     */
    public static function forgetSubject(Model $subject): void
    {
        self::where(static fn ($query) => $query
            ->where(static fn ($about) => $about->where('data->subject_type', $subject->getMorphClass())->where('data->subject_id', $subject->getKey()))
            ->when($subject instanceof Comment, static fn ($about) => $about->orWhere('data->comment_id', $subject->getKey())))
            ->delete();
    }

    /**
     * @return Attribute<bool, bool>
     */
    protected function isRead(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->read_at !== null,
            set: static fn (bool $value): array => ['read_at' => $value ? now() : null],
        );
    }
}
