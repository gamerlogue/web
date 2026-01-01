<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
use Spatie\Activitylog\Traits\CausesActivity;

// TODO: Authorize PATCH only for the user themselves
#[ApiResource(
    description: 'A user of the application.',
    operations: [
        new GetCollection,
        new Get,
        new Patch
    ]
)]
class User extends Authenticatable implements MustVerifyEmail, PortableContract
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use CausesActivity, HasApiTokens, HasFactory, HasUuids, LogsInWithOidc, Notifiable, Portable, SoftDeletes;

    /**
     * The relations to include in the downloadable data.
     */
    protected array $gdprWith = ['actions', 'activities'];

    /**
     * The attributes that should be hidden for the downloadable data.
     */
    protected array $gdprHidden = ['password', 'remember_token', 'passkeys.credential_id', 'passkeys.data'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'nickname',
        'picture',
        'email',
        'password',
        'email_verified_at',
        'name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'id',
        'password',
        'email',
        'remember_token',
    ];

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
