<?php

use App\Enums\LibraryEntryCompletionStatus;
use App\Enums\LibraryEntryStatus;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('library_entries', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained('users');
            $table->integer('game_id');
            $table->enum('status', LibraryEntryStatus::cases());
            $table->enum('completion_status', LibraryEntryCompletionStatus::cases())->nullable();
            $table->boolean('owned');
            $table->integer('edition_id')->nullable();
            $table->json('platforms_ids')->default('[]');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('played_time')->nullable();
            $table->decimal('rating')->nullable();
            $table->json('rating_details')->default('{}');
            $table->longText('review')->nullable();
            $table->timestamps();

            $table->integer('edition_id_index')
                ->virtualAs('COALESCE(edition_id, 0)');

            $table->unique(['game_id', 'edition_id_index', 'user_id'], 'unique_entries');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('library_entries');
    }
};
