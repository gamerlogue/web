<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Integer notifiable IDs cannot be mapped to users' UUIDs. Both directions require an empty
 * table, and MariaDB requires a character column between its integer and native UUID types.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('notifications')->exists()) {
            throw new RuntimeException('Cannot convert notification IDs to UUIDs while notifications exist.');
        }

        Schema::table('notifications', static function (Blueprint $table): void {
            $table->char('notifiable_id', 36)->change();
        });

        Schema::table('notifications', static function (Blueprint $table): void {
            $table->uuid('notifiable_id')->change();
        });
    }

    public function down(): void
    {
        if (DB::table('notifications')->exists()) {
            throw new RuntimeException('Cannot convert notification IDs to integers while notifications exist.');
        }

        Schema::table('notifications', static function (Blueprint $table): void {
            $table->char('notifiable_id', 36)->change();
        });

        Schema::table('notifications', static function (Blueprint $table): void {
            $table->unsignedBigInteger('notifiable_id')->change();
        });
    }
};
