<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Users, the only notifiables, have UUIDs: the integer column could never hold one. Any existing
 * row could not belong to a user either, so there is nothing to convert.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', static function (Blueprint $table): void {
            $table->uuid('notifiable_id')->change();
        });
    }

    public function down(): void
    {
        Schema::table('notifications', static function (Blueprint $table): void {
            $table->unsignedBigInteger('notifiable_id')->change();
        });
    }
};
