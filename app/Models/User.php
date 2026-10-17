<?php

declare(strict_types=1);

namespace App\Models;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\QueryParameter;
use App\Enums\Visibility;
use App\Http\Requests\UserFormRequest;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Maicol07\OIDCClient\Models\OidcAuthMapping;
use Maicol07\OIDCClient\Models\Traits\LogsInWithOidc;
use Maicol07\OpenIDConnect\UserInfo;
use Soved\Laravel\Gdpr\Contracts\Portable as PortableContract;
use Soved\Laravel\Gdpr\Portable;
use Symfony\Component\TypeInfo\Type\BuiltinType;
use Symfony\Component\TypeInfo\TypeIdentifier;

#[ApiResource(
    description: 'A user of the application.',
    operations: [
        new GetCollection,
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
class User extends Authenticatable implements MustVerifyEmail, PortableContract
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, HasUuids, LogsInWithOidc, Notifiable, Portable, SoftDeletes;

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
