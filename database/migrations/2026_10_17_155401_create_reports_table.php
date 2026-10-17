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
        Schema::create('reports', static function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            // A string id: the reported subject may be a user (UUID) or any other content (integer).
            $table->string('reportable_type');
            $table->string('reportable_id');
            $table->string('reason');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'reportable_type', 'reportable_id']);
            $table->index(['reportable_type', 'reportable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
