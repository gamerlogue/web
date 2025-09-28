<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            // SQLite non supporta dropPrimary/dropColumn su PK: ricreo le tabelle
            DB::transaction(static function () {
                // Costruisci tabella users_temp con UUID PK
                Schema::create('users_temp', static function (Blueprint $table) {
                    $table->uuid('id')->primary();
                    $table->string('name');
                    $table->string('email')->unique();
                    $table->timestamp('email_verified_at')->nullable();
                    $table->string('password');
                    $table->rememberToken();
                    $table->timestamps();
                });

                // Copia dati con nuova UUID; mappatura old_id => new_uuid
                $idMap = [];
                foreach (DB::table('users')->get() as $user) {
                    $newId = (string) Str::uuid();
                    $idMap[(string) $user->id] = $newId;
                    DB::table('users_temp')->insert([
                        'id' => $newId,
                        'name' => $user->name,
                        'email' => $user->email,
                        'email_verified_at' => $user->email_verified_at,
                        'password' => $user->password,
                        'remember_token' => $user->remember_token,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                    ]);
                }

                // Ricrea sessions con user_id UUID e vincolo FK
                Schema::create('sessions_temp', static function (Blueprint $table) {
                    $table->string('id')->primary();
                    $table->foreignUuid('user_id')->nullable()->index()->constrained('users')->cascadeOnDelete();
                    $table->string('ip_address', 45)->nullable();
                    $table->text('user_agent')->nullable();
                    $table->longText('payload');
                    $table->integer('last_activity')->index();
                });

                foreach (DB::table('sessions')->get() as $s) {
                    $mappedUserId = null;
                    if (! is_null($s->user_id)) {
                        $key = (string) $s->user_id;
                        $mappedUserId = $idMap[$key] ?? null;
                    }
                    DB::table('sessions_temp')->insert([
                        'id' => $s->id,
                        'user_id' => $mappedUserId,
                        'ip_address' => $s->ip_address,
                        'user_agent' => $s->user_agent,
                        'payload' => $s->payload,
                        'last_activity' => $s->last_activity,
                    ]);
                }

                // Sostituisci le tabelle
                Schema::drop('sessions');
                Schema::rename('sessions_temp', 'sessions');

                Schema::drop('users');
                Schema::rename('users_temp', 'users');
            });

            return;
        }

        // Altri driver (MySQL/Postgres): percorso originale con PK UUID e default DB-side
        Schema::table('users', static function (Blueprint $table) {
            $table->dropColumn('id');
            $table->uuid('id')
                ->primary()
                ->index()
                ->unique()
                ->default(new Expression('UUID_V7()'))
                ->first();
        });

        Schema::table('sessions', static function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->foreignIdFor(User::class, 'user_id')
                ->after('id')
                ->index()
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            DB::transaction(function () {
                // Torna a integer PK su users e integer FK su sessions
                Schema::create('users_temp', static function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->string('email')->unique();
                    $table->timestamp('email_verified_at')->nullable();
                    $table->string('password');
                    $table->rememberToken();
                    $table->timestamps();
                });

                // Mappatura inversa UUID -> new autoincrement id
                $idMap = [];
                foreach (DB::table('users')->orderBy('created_at')->get() as $user) {
                    // Inserisci per ottenere nuovo id autoincrement
                    $newId = DB::table('users_temp')->insertGetId([
                        'name' => $user->name,
                        'email' => $user->email,
                        'email_verified_at' => $user->email_verified_at,
                        'password' => $user->password,
                        'remember_token' => $user->remember_token,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                    ]);
                    $idMap[(string) $user->id] = $newId;
                }

                Schema::create('sessions_temp', static function (Blueprint $table) {
                    $table->string('id')->primary();
                    $table->foreignId('user_id')->nullable()->index();
                    $table->string('ip_address', 45)->nullable();
                    $table->text('user_agent')->nullable();
                    $table->longText('payload');
                    $table->integer('last_activity')->index();
                });

                foreach (DB::table('sessions')->get() as $session) {
                    $mappedUserId = null;
                    if (! is_null($session->user_id)) {
                        $key = (string) $session->user_id;
                        $mappedUserId = $idMap[$key] ?? null;
                    }
                    DB::table('sessions_temp')->insert([
                        'id' => $session->id,
                        'user_id' => $mappedUserId,
                        'ip_address' => $session->ip_address,
                        'user_agent' => $session->user_agent,
                        'payload' => $session->payload,
                        'last_activity' => $session->last_activity,
                    ]);
                }

                Schema::drop('sessions');
                Schema::rename('sessions_temp', 'sessions');

                Schema::drop('users');
                Schema::rename('users_temp', 'users');
            });

            return;
        }

        // Altri driver: ripristina id autoincrement e FK integer
        Schema::table('users', static function (Blueprint $table) {
            $table->dropColumn('id');
            $table->id()->primary()->unique()->first();
        });

        Schema::table('sessions', static function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->foreignIdFor(User::class, 'user_id')
                ->after('id')
                ->index()
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();
        });
    }
};
