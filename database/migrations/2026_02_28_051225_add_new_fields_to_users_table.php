<?php

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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
            $table->string('avatar')->nullable()->after('email');
            $table->string('phone')->nullable()->after('avatar');
            $table->boolean('is_active')->default(true)->after('role');
            $table->softDeletes()->after('remember_token'); // optional soft delete
        });

        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->timestamp('expires_at')->nullable()->after('created_at');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->timestamps()->after('last_activity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username','avatar','phone','is_active']);
            $table->dropSoftDeletes();
        });

        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->dropColumn('expires_at');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
