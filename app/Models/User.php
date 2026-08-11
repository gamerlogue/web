<?php

declare(strict_types=1);

namespace App\Models;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
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

#[ApiResource(
    description: 'A user of the application.',
    operations: [
        new GetCollection,
        new Get,
        new Patch
    ],
    rules: UserFormRequest::class
)]
class User extends Authenticatable implements MustVerifyEmail, PortableContract
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, HasUuids, LogsInWithOidc, Notifiable, Portable, SoftDeletes;

    /**
     * Declared as properties rather than through the #[Fillable] and #[Hidden] attributes: those
     * are applied by the constructor, and API Platform inspects the model through
     * newInstanceWithoutConstructor(), which would leave every field visible to the serializer.
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
    ];

    /** @var list<string> */
    protected $hidden = ['email', 'id', 'password', 'remember_token'];

    /**
     * The relations to include in the downloadable data.
     */
    protected array $gdprWith = ['actions'];

    /**
     * The attributes that should be hidden for the downloadable data.
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
        ];
    }

    /**
     * Get the user's full name.
     *
     * @return Attribute<string>
     */
    public function name(): Attribute
    {
        return Attribute::make(
            get: fn () => collect([$this->first_name, $this->last_name])
                ->filter()
                ->implode(' '),
            set: static fn ($value) => [
                'first_name' => explode(' ', $value, 2)[0] ?? null,
                'last_name' => explode(' ', $value, 2)[1] ?? null,
            ]
        );
    }

    public function mapOIDCUserinfo(string $issuer, UserInfo $user_info, OidcAuthMapping $mapping): void
    {
        $this->first_name = $user_info->given_name;
        $this->last_name = $user_info->family_name;
        $this->nickname = $user_info->nickname;
        $this->picture = $user_info->picture;
        $this->email = $user_info->email;
        $this->email_verified_at = $user_info->email_verified ? now() : null;
    }
}
