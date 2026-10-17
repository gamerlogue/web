<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', static function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('verb');
            // The morph class, which stays App\Models\User for users: aliasing it would orphan every
            // existing morph to a user, Sanctum tokens first. The API exposes `subject_type` instead.
            // A string id, because the subject may be a user (UUID) or any other content (integer).
            $table->string('subject_class');
            $table->string('subject_id');
            $table->json('payload');
            $table->timestamps();
            $table->index(['user_id', 'created_at']);
            $table->index(['subject_class', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
