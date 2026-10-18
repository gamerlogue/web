<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function (): void {
    config(['database.notification_migration_original_connection' => DB::getDefaultConnection()]);
    $database = getenv('NOTIFICATION_MIGRATION_DATABASE');

    // MariaDB uses a dedicated connection and a temporary table that shadows the real one.
    config(['database.connections.notification_migration' => $database === false
        ? ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '']
        : array_replace(config('database.connections.mariadb'), ['database' => $database, 'url' => null])]);

    DB::setDefaultConnection('notification_migration');
    Schema::swap(DB::connection()->getSchemaBuilder());

    Schema::create('notifications', static function (Blueprint $table): void {
        if (DB::connection()->getDriverName() === 'mariadb') {
            $table->temporary();
        }

        $table->uuid('id')->primary();
        $table->morphs('notifiable');
        $table->text('data');
    });
});

afterEach(function (): void {
    DB::setDefaultConnection(config('database.notification_migration_original_connection'));
    Schema::swap(DB::connection()->getSchemaBuilder());
    DB::purge('notification_migration');
});

test('notification IDs migrate to UUIDs and back on an empty table', function (): void {
    $migration = require database_path('migrations/2026_10_17_165207_change_notifiable_id_to_uuid_in_notifications_table.php');

    $migration->up();

    if (DB::connection()->getDriverName() === 'mariadb') {
        expect(DB::selectOne("SHOW COLUMNS FROM notifications WHERE Field = 'notifiable_id'")->Type)->toBe('uuid');
    }

    $migration->down();

    if (DB::connection()->getDriverName() === 'mariadb') {
        expect(DB::selectOne("SHOW COLUMNS FROM notifications WHERE Field = 'notifiable_id'")->Type)->toContain('bigint')->toContain('unsigned');
        expect(DB::select("SHOW INDEX FROM notifications WHERE Key_name = 'notifications_notifiable_type_notifiable_id_index'"))->toHaveCount(2);
    } else {
        expect(Schema::hasIndex('notifications', ['notifiable_type', 'notifiable_id']))->toBeTrue();
    }

    $migration->up();
    $userId = '0199f11a-27f5-7000-8000-000000000001';
    DB::table('notifications')->insert(['id' => $userId, 'notifiable_type' => 'user', 'notifiable_id' => $userId, 'data' => '{}']);

    expect(DB::table('notifications')->value('notifiable_id'))->toBe($userId);
});

test('notification migration preserves existing integer IDs when refusing conversion', function (): void {
    DB::table('notifications')->insert(['id' => '0199f11a-27f5-7000-8000-000000000001', 'notifiable_type' => 'user', 'notifiable_id' => 42, 'data' => '{}']);
    $migration = require database_path('migrations/2026_10_17_165207_change_notifiable_id_to_uuid_in_notifications_table.php');

    expect(fn () => $migration->up())->toThrow(RuntimeException::class, 'Cannot convert notification IDs to UUIDs');
    expect((int) DB::table('notifications')->value('notifiable_id'))->toBe(42);
});

test('notification rollback preserves existing UUIDs when refusing conversion', function (): void {
    $migration = require database_path('migrations/2026_10_17_165207_change_notifiable_id_to_uuid_in_notifications_table.php');
    $migration->up();
    $userId = '0199f11a-27f5-7000-8000-000000000001';
    DB::table('notifications')->insert(['id' => $userId, 'notifiable_type' => 'user', 'notifiable_id' => $userId, 'data' => '{}']);

    expect(fn () => $migration->down())->toThrow(RuntimeException::class, 'Cannot convert notification IDs to integers');
    expect(DB::table('notifications')->value('notifiable_id'))->toBe($userId);
});
