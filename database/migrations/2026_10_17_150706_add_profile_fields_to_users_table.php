<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', static function (Blueprint $table): void {
            $table->string('bio', 500)->nullable();
            $table->unsignedBigInteger('banner_game_id')->nullable();
            $table->string('banner_image_id')->nullable();
            $table->json('platforms_ids')->default('[]');
            $table->string('visibility')->default('public');
            // Nicknames are unique regardless of case. Fails on existing case-insensitive duplicates,
            // which have to be resolved by hand before migrating.
            $table->string('nickname_key')->nullable()->virtualAs('LOWER(nickname)')->unique();
        });
    }

    public function down(): void
    {
        Schema::table('users', static function (Blueprint $table): void {
            $table->dropUnique(['nickname_key']);
            $table->dropColumn(['bio', 'banner_game_id', 'banner_image_id', 'platforms_ids', 'visibility', 'nickname_key']);
        });
    }
};
