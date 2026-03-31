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
        Schema::table('job_applications', function (Blueprint $table) {
            //
             $table->string('status')->default('1')->after('profile_photo'); 
            // Change 'some_existing_column' to the column after which you want to add this

            $table->string('application_status')->nullable()->after('status');
            $table->text('message')->nullable()->after('application_status');
            $table->json('questions')->nullable()->after('message');
            $table->text('old')->nullable()->after('questions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            //
             $table->dropColumn(['status', 'application_status', 'message', 'questions','old']);
        });
    }
};
