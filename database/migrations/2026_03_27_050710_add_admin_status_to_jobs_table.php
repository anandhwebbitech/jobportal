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
        Schema::table('jobs', function (Blueprint $table) {
            //
            $table->string('admin_status')->nullable()->after('status');
            $table->string('is_new')->nullable()->after('admin_status');
            $table->text('old')->nullable()->after('is_new');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            //
             $table->dropColumn([
                'admin_status',
                'is_new',
                'old'
            ]);
        });
    }
};
