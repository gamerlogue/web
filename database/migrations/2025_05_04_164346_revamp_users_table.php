<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            // Rename the 'name' column to 'nickname'
            $table->renameColumn('name', 'nickname');

            // Add the columns: 'first_name', 'last_name', 'picture'
            $table->string('first_name')->after('nickname')->nullable();
            $table->string('last_name')->after('first_name')->nullable();
            $table->string('picture')->after('last_name')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', static function (Blueprint $table) {
            // Rename the 'nickname' column back to 'name'
            $table->renameColumn('nickname', 'name');

            // Drop the columns: 'first_name', 'last_name', 'picture'
            $table->dropColumn(['first_name', 'last_name', 'picture']);
        });
    }
};
