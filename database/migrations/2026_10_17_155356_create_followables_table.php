<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * overtrue/laravel-follow's table, written here rather than published: its own migration types
 * user_id as an integer, while users have UUIDs.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('followables', static function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->uuidMorphs('followable');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'followable_type', 'followable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('followables');
    }
};
