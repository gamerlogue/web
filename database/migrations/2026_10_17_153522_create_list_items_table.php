<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('list_items', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('list_id')->constrained('game_lists')->cascadeOnDelete();
            $table->unsignedBigInteger('game_id');
            $table->unsignedInteger('position');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->unique(['list_id', 'game_id']);
            $table->index('game_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('list_items');
    }
};
