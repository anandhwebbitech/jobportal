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
        Schema::create('job_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title'); // PHP / Laravel Jobs
            $table->string('keywords')->nullable(); // search keywords
            // 🔹 Location
            $table->string('location')->nullable(); // Tamil Nadu / Remote
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable()->default('India');

            // 🔹 Job Filters
            $table->string('job_type')->nullable(); // full-time, part-time
            $table->string('experience_level')->nullable(); // fresher, mid, senior

            // 🔹 Salary
            $table->integer('salary_min')->nullable();
            $table->integer('salary_max')->nullable();

            // 🔹 Alert Settings
            $table->enum('frequency', ['daily', 'weekly', 'instant'])->default('daily');

            // 🔹 Status
            $table->integer('is_active')->default(0);
            $table->integer('status')->default(1);

            // 🔹 Meta
            $table->integer('match_count')->default(0); // "4 new matches"
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_alerts');
    }
};
