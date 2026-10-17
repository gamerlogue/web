<?php

declare(strict_types=1);

namespace App\Models;

use ApiPlatform\Laravel\Eloquent\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\QueryParameter;
use App\Enums\Visibility;
use App\Exceptions\ApiDomainException;
use App\Http\Requests\UserFormRequest;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Maicol07\OIDCClient\Models\OidcAuthMapping;
use Maicol07\OIDCClient\Models\Traits\LogsInWithOidc;
use Maicol07\OpenIDConnect\UserInfo;
use Overtrue\LaravelFollow\Traits\Followable;
use Overtrue\LaravelFollow\Traits\Follower;
use Soved\Laravel\Gdpr\Contracts\Portable as PortableContract;
use Soved\Laravel\Gdpr\Portable;
use Symfony\Component\TypeInfo\Type\BuiltinType;
use Symfony\Component\TypeInfo\TypeIdentifier;

#[ApiResource(
    description: 'A user of the application.',
    operations: [
        new GetCollection,
        // Their own link handling (none): the {id} is the followed or following user, which
        // OwnedResourcesExtension resolves, not the id of the users listed.
        new GetCollection(uriTemplate: '/users/{id}/followers', stateOptions: new Options(handleLinks: [self::class, 'unlinked'])),
        new GetCollection(uriTemplate: '/users/{id}/following', stateOptions: new Options(handleLinks: [self::class, 'unlinked'])),
        new Get,
        new Patch
    ],
    rules: UserFormRequest::class
)]
#[QueryParameter('filter[search]', description: 'Search users by nickname or name; without it the collection holds only the caller', constraints: ['string', 'max:100'])]
#[ApiProperty(property: 'email', security: 'viewPrivateFields', writable: false)]
#[ApiProperty(property: 'email_verified_at', security: 'viewPrivateFields', writable: false)]
#[ApiProperty(description: 'Where the identity provider lets the user change their picture, null if it has no such page.', property: 'picture_edit_url', security: 'viewPrivateFields', writable: false)]
#[ApiProperty(property: 'first_name', security: 'viewProfile')]
#[ApiProperty(property: 'last_name', security: 'viewProfile')]
#[ApiProperty(property: 'bio', security: 'viewProfile')]
#[ApiProperty(description: 'The IGDB game the banner image belongs to.', property: 'banner_game_id', security: 'viewProfile')]
#[ApiProperty(description: 'The IGDB image_id of the artwork or screenshot used as banner.', property: 'banner_image_id', security: 'viewProfile')]
#[ApiProperty(description: 'The IGDB platforms the user owns.', property: 'platforms_ids', security: 'viewProfile', nativeType: new BuiltinType(TypeIdentifier::ARRAY))]
#[ApiProperty(property: 'created_at', security: 'viewProfile')]
#[ApiProperty(property: 'updated_at', security: 'viewProfile')]
#[ApiProperty(property: 'followers_count', security: 'viewProfile', writable: false)]
#[ApiProperty(property: 'following_count', security: 'viewProfile', writable: false)]
#[ApiProperty(description: 'Whether the caller follows this user.', property: 'is_followed_by_me', security: 'viewProfile', writable: false)]
#[ApiProperty(description: 'Whether this user follows the caller.', property: 'follows_me', security: 'viewProfile', writable: false)]
// The follow relations exist for queries; followers are listed by /users/{id}/followers instead.
#[ApiProperty(property: 'followers', readable: false, writable: false)]
#[ApiProperty(property: 'approved_followers', readable: false, writable: false)]
#[ApiProperty(property: 'not_approved_followers', readable: false, writable: false)]
// Whom a user blocked is theirs only, read through /blocks.
#[ApiProperty(property: 'blocks', readable: false, writable: false)]
class User extends Authenticatable implements MustVerifyEmail, PortableContract
{
    /** @use HasFactory<UserFactory> */
    use Followable, Follower, HasApiTokens, HasFactory, HasUuids, LogsInWithOidc, Notifiable, Portable, SoftDeletes;

    /**
     * Declared as properties rather than through the #[Fillable] and #[Hidden] attributes: those
     * are applied by the constructor, and API Platform inspects the model through
     * newInstanceWithoutConstructor(), which would leave every field visible to the serializer.
     *
     * list<string>, not string[]: the parent declares it that way and the narrower type is the
     * only one covariant with it.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'email_verified_at',
        'password',
        'first_name',
        'last_name',
        'picture',
        'nickname',
        'name',
        'bio',
        'banner_game_id',
        'banner_image_id',
        'platforms_ids',
        'visibility',
    ];

    /** @var list<string> */
    protected $hidden = ['id', 'password', 'remember_token', 'nickname_key'];

    /** @var array<string, mixed> */
    protected $attributes = ['visibility' => 'public', 'platforms_ids' => '[]'];

    /**
     * The relations to include in the downloadable data.
     *
     * @var string[]
     */
    protected array $gdprWith = ['actions'];

    /**
     * The attributes that should be hidden for the downloadable data.
     *
     * @var string[]
     */
    protected array $gdprHidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'banner_game_id' => 'integer',
            'platforms_ids' => 'array',
            'visibility' => Visibility::class,
        ];
    }

    /**
     * Get the user's full name.
     *
     * @return Attribute<string, array{first_name: string|null, last_name: string|null}>
     */
    public function name(): Attribute
    {
        return Attribute::make(
            get: fn () => collect([$this->first_name, $this->last_name])
                ->filter()
                ->implode(' '),
            set: static fn ($value) => [
                'first_name' => explode(' ', $value, 2)[0],
                'last_name' => explode(' ', $value, 2)[1] ?? null,
            ]
        );
    }

    /**
     * Memoized by blockedUserIds(). The authenticated user is resolved anew for every request, so
     * this cannot outlive one.
     *
     * @var list<string>|null
     */
    private ?array $blockedUserIds = null;

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    public static function unlinked(Builder $query): Builder
    {
        return $query;
    }

    /**
     * The follow counters and flags in two subqueries each, instead of one query per user.
     *
     * @param  Builder<User>  $query
     */
    public function scopeWithSocialContext(Builder $query): void
    {
        $viewerId = auth()->id();
        $query->withCount(['followers', 'followings as following_count'])->withExists([
            'followers as is_followed_by_me' => static fn (Builder $follower) => $follower->where('followables.user_id', $viewerId),
            'followings as follows_me' => static fn (Builder $following) => $following->where('followable_id', $viewerId),
        ]);
    }

    /**
     * @return HasMany<UserBlock, $this>
     */
    public function blocks(): HasMany
    {
        return $this->hasMany(UserBlock::class);
    }

    /**
     * The users in a block with this one, whichever side blocked.
     *
     * @return list<string>
     */
    public function blockedUserIds(): array
    {
        return $this->blockedUserIds ??= UserBlock::where('user_id', $this->id)->pluck('blocked_id')
            ->merge(UserBlock::where('blocked_id', $this->id)->pluck('user_id'))
            ->values()
            ->all();
    }

    public function isBlockedWith(self $other): bool
    {
        return in_array($other->id, $this->blockedUserIds(), true);
    }

    public function forgetBlockedUserIds(): void
    {
        $this->blockedUserIds = null;
    }

    /**
     * Refuses another user everything beyond this profile's public card, with the code the client
     * branches on: a block first, then a private profile.
     *
     * @throws ApiDomainException
     */
    public function ensureProfileVisibleTo(self $viewer): void
    {
        if ($viewer->is($this)) {
            return;
        }
        if ($viewer->isBlockedWith($this)) {
            throw ApiDomainException::userBlocked();
        }
        if ($this->visibility !== Visibility::Public) {
            throw ApiDomainException::profilePrivate();
        }
    }

    /**
     * The four follow attributes come from withSocialContext(); these only cover a user loaded
     * without it, such as the response to a PATCH.
     *
     * @return Attribute<int, never>
     */
    protected function followersCount(): Attribute
    {
        return Attribute::get(fn (?int $value): int => $value ?? $this->followers()->count());
    }

    /**
     * @return Attribute<int, never>
     */
    protected function followingCount(): Attribute
    {
        return Attribute::get(fn (?int $value): int => $value ?? $this->followings()->count());
    }

    /**
     * @return Attribute<bool, never>
     */
    protected function isFollowedByMe(): Attribute
    {
        return Attribute::get(fn (mixed $value): bool => $value === null
            ? $this->followers()->where('followables.user_id', auth()->id())->exists()
            : (bool) $value);
    }

    /**
     * @return Attribute<bool, never>
     */
    protected function followsMe(): Attribute
    {
        return Attribute::get(fn (mixed $value): bool => $value === null
            ? $this->followings()->where('followable_id', auth()->id())->exists()
            : (bool) $value);
    }

    /**
     * There is a single OIDC provider, so its account page is the only candidate.
     *
     * @return Attribute<string|null, never>
     */
    public function pictureEditUrl(): Attribute
    {
        return Attribute::get(static fn (): ?string => config('services.oidc.picture_edit_url'));
    }

    public function mapOIDCUserinfo(string $issuer, UserInfo $user_info, OidcAuthMapping $mapping): void
    {
        $this->first_name = $user_info->given_name;
        $this->last_name = $user_info->family_name;
        // The nickname is the user's to edit: the provider only seeds it, and only while it is free.
        if ($this->nickname === null && $user_info->nickname !== null
            && ! self::where('nickname_key', mb_strtolower($user_info->nickname))->exists()) {
            $this->nickname = $user_info->nickname;
        }
        $this->picture = $user_info->picture;
        $this->email = $user_info->email;
        // A date string, not a Carbon instance: the 'datetime' cast parses it back on read, and
        // Larastan types the column from the migration because it does not read the casts() method.
        $this->email_verified_at = $user_info->email_verified ? now()->toDateTimeString() : null;
    }
}
