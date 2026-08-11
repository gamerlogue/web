<?php

declare(strict_types=1);

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;

require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Test database schema
|--------------------------------------------------------------------------
|
| API Platform derives its routes from the Eloquent metadata, which it reads
| from the database while the service providers boot. With an empty database
| the item operations lose their {id} and every /api/<resource>/{id} request
| 404s. RefreshDatabase migrates too late to help, so the schema has to exist
| before the first application boots: a file database, migrated once here.
|
*/

// This bootstrap drops and recreates every table, so refuse to run unless phpunit.xml's
// <server> overrides are in effect. Without them the Sail container's own DB_CONNECTION
// wins and migrate:fresh would wipe the local development database.
if (($_SERVER['DB_CONNECTION'] ?? null) !== 'sqlite') {
    throw new RuntimeException(sprintf(
        'Refusing to prepare the test database: DB_CONNECTION is "%s", expected "sqlite". Is phpunit.xml being loaded?',
        $_SERVER['DB_CONNECTION'] ?? 'unset',
    ));
}

// phpunit.xml points DB_DATABASE at a path relative to the project root.
if (realpath(getcwd()) !== realpath(__DIR__ . '/..')) {
    throw new RuntimeException('Run the test suite from the project root: the sqlite path in phpunit.xml is relative to it.');
}

touch(__DIR__ . '/../database/testing.sqlite');

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

Artisan::call('migrate:fresh', ['--force' => true]);

$app->flush();

// Laravel's HandleExceptions bootstrapper installs global handlers; leaving them behind makes
// PHPUnit mark every test as risky once the test case removes them.
restore_exception_handler();
restore_error_handler();
