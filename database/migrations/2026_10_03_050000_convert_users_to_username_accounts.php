<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users') || Schema::hasColumn('users', 'username')) {
            return;
        }

        if (! Schema::hasColumn('users', 'id')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 50)->nullable();
        });

        $takenUsernames = [];

        foreach (DB::table('users')->orderBy('id')->get(['id', 'name', 'email']) as $user) {
            $baseUsername = trim((string) ($user->name ?: strstr((string) $user->email, '@', true)));
            $baseUsername = $baseUsername !== '' ? mb_substr($baseUsername, 0, 42) : 'user';
            $username = $baseUsername;
            $suffix = 1;

            while (isset($takenUsernames[mb_strtolower($username)])) {
                $username = mb_substr($baseUsername, 0, 42).'-'.$suffix++;
            }

            $takenUsernames[mb_strtolower($username)] = true;

            DB::table('users')->where('id', $user->id)->update(['username' => $username]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->unique('username');
            $table->dropUnique('users_email_unique');
            $table->renameColumn('id', 'user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'email',
                'email_verified_at',
                'remember_token',
                'created_at',
                'updated_at',
            ]);
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('users') || ! Schema::hasColumn('users', 'username')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        foreach (DB::table('users')->orderBy('user_id')->get(['user_id', 'username']) as $user) {
            DB::table('users')->where('user_id', $user->user_id)->update([
                'name' => $user->username,
                'email' => 'user-'.$user->user_id.'@legacy.local',
            ]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->unique('email');
            $table->dropUnique('users_username_unique');
            $table->renameColumn('user_id', 'id');
            $table->dropColumn('username');
        });
    }
};
