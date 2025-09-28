<?php

use Spatie\Activitylog\Models\Activity;

function add_ip_and_device_info_to_log(Activity $activity): void
{
    $device = request()->device();
    $activity->properties = ($activity->properties ?: collect())
        ->put('ip', request()->ip())
        ->put('device', "{$device->getClient('name')} {$device->getClient('version')} ({$device->getOs('name')} {$device->getOs('version')})");
}
