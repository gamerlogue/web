<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * qirolab/laravel-reactions' table, written here rather than published: its own migration types
 * user_id as an integer, while users have UUIDs. One reaction per user and subject.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reactions', static function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->morphs('reactable');
            // `like`, or a single emoji grapheme: a few code points, joiners and modifiers included.
            $table->string('type', 32);
            $table->timestamps();
            $table->unique(['user_id', 'reactable_type', 'reactable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
