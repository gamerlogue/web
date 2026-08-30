<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schedule;

Schedule::command('telescope:prune --hours=48')->daily();

// Without it the Horizon dashboard's metrics stay empty.
Schedule::command('horizon:snapshot')->everyFiveMinutes();
