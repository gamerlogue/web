<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The package migration declares `morphs('tokenable')`, which lands tokenable_id as an unsigned
 * bigint. Users are keyed by UUID, so MariaDB truncated the value instead of storing it — warning
 * 1265, fatal under strict mode — and every native token exchange died on the insert. Sanctum's own
 * personal_access_tokens table already uses uuidMorphs; this brings the refresh token family in line.
 *
 * The conversion goes through CHAR(36) because MariaDB refuses to cast `bigint unsigned` straight to
 * its native `uuid` type (error 4078). Both steps modify the column in place, so an instance holding
 * rows keeps them and the indexes covering the column survive.
 */
return new class extends Migration
{
    public function up(): void
    {
        $this->convert(fn (Blueprint $table) => $table->uuid('tokenable_id')->change());
    }

    public function down(): void
    {
        $this->convert(fn (Blueprint $table) => $table->unsignedBigInteger('tokenable_id')->change());
    }

    private function convert(Closure $target): void
    {
        $table = config('sanctum-refresh-token.table', 'refresh_tokens');

        Schema::table($table, static function (Blueprint $blueprint): void {
            $blueprint->char('tokenable_id', 36)->change();
        });

        Schema::table($table, $target);
    }
};
