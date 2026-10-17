<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * beyondcode/laravel-comments' table, written here: users have UUIDs, and comments add a spoiler
 * flag. A reply is a comment whose commentable is another comment.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', static function (Blueprint $table): void {
            $table->id();
            $table->morphs('commentable');
            $table->text('comment');
            $table->boolean('spoiler')->default(false);
            $table->boolean('is_approved')->default(true);
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
