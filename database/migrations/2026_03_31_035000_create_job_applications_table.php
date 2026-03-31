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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Personal Info
            $table->string('applicant_name');
            $table->string('applicant_email');
            $table->string('applicant_mobile');
            $table->string('current_location');
            $table->string('highest_qualification');

            // Experience
            $table->string('experience_level'); // fresher / experienced
            $table->string('years_experience')->nullable();
            $table->string('previous_company')->nullable();
            $table->string('previous_designation')->nullable();

            // Extra
            $table->text('cover_letter')->nullable();
            $table->string('expected_salary')->nullable();
            $table->string('notice_period');

            // Files
            $table->string('resume');
            $table->string('profile_photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
