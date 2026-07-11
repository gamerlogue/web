<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('library_entries', static function (Blueprint $table) {
            $table->dropUnique('unique_entries');
            $table->dropColumn(['edition_id_index', 'edition_id']);
            $table->json('editions_ids')->default('[]');
            $table->unique(['game_id', 'user_id'], 'unique_game_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('library_entries', static function (Blueprint $table) {
            $table->dropUnique('unique_game_user');
            $table->dropColumn('editions_ids');
            $table->integer('edition_id')->nullable();
            $table->integer('edition_id_index')
                ->virtualAs('COALESCE(edition_id, 0)');
            $table->unique(['game_id', 'edition_id_index', 'user_id'], 'unique_entries');
        });
    }
};
