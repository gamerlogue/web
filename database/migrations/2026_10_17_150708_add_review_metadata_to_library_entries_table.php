<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('library_entries', static function (Blueprint $table): void {
            $table->boolean('review_spoiler')->default(false);
            $table->timestamp('review_updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('library_entries', static function (Blueprint $table): void {
            $table->dropColumn(['review_spoiler', 'review_updated_at']);
        });
    }
};
