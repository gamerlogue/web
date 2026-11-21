<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * FCM registration tokens of the native clients. A 4096-character unique key exceeds InnoDB's
     * prefix limit; MariaDB ≥ 10.4 backs it with a hash index instead.
     */
    public function up(): void
    {
        Schema::create('device_tokens', static function (Blueprint $table): void {
            $table->id();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('token', 4096)->unique();
            $table->string('platform');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_tokens');
    }
};
