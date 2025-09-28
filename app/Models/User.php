<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Soved\Laravel\Gdpr\Contracts\Portable as PortableContract;
use Soved\Laravel\Gdpr\Portable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements MustVerifyEmail, PortableContract
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use CausesActivity, HasFactory, HasUuids,
        LogsActivity, Notifiable, Portable, SoftDeletes;

    protected $keyType = 'uuid';

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
        'password',
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['first_name', 'last_name', 'nickname', 'email', 'picture', 'password'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /** @noinspection PhpUnused */
    public function tapActivity(Activity $activity, string $eventName): void
    {
        add_ip_and_device_info_to_log($activity);

        $properties = $activity->properties->dot();

        // Mask password and old_password fields in activity
        if ($eventName === 'updated' && $properties->has('attributes.password')) {
            $properties->put('attributes.password', '********');
        }

        if ($eventName === 'updated' && $properties->has('attributes.old_password')) {
            $properties->put('attributes.old_password', '********');
        }

        if ($eventName === 'deleted' && $properties->has('old.password')) {
            $properties->put('old.password', '********');
        }

        $activity->properties = $properties->undot();
    }
}
