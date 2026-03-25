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
        Schema::create('employer_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Company Info
            $table->string('company_name');
            $table->text('company_address');
            $table->string('state');
            $table->string('district');
            $table->string('city');
            $table->string('pincode', 10);

            // Owner
            $table->string('owner_name');
            $table->string('owner_mobile');

            // HR
            $table->string('hr_name');
            $table->string('hr_mobile');

            // Account
            $table->string('email');

            // Business Details
            $table->string('gst_number');
            $table->string('pan_number');
            $table->string('msme_number')->nullable();

            // Files
            $table->string('gst_certificate');
            $table->string('pan_document');
            $table->string('msme_certificate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employer_details');
    }
};
