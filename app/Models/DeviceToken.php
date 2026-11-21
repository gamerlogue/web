<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * An FCM registration token of a native client, owned by whoever registered it last.
 */
class DeviceToken extends Model
{
    protected $fillable = ['user_id', 'token', 'platform'];
}
