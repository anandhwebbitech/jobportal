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
        Schema::table('notifications', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('send_from')->nullable()->after('id');
            $table->unsignedBigInteger('send_to')->nullable()->after('send_from');
            $table->string('type')->nullable()->after('send_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            //
             $table->dropColumn(['send_from', 'send_to', 'type']);
        });
    }
};
