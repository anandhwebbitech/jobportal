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
        Schema::create('jobs', function (Blueprint $table) {

            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('company_name');

            $table->string('location')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->default('Tamil Nadu');

            $table->string('experience')->nullable();

            $table->string('salary_min')->nullable();
            $table->string('salary_max')->nullable();

            $table->string('job_type')->nullable(); 
            // full-time, part-time, contract

            $table->text('description')->nullable();
            $table->text('responsibilities')->nullable();
            $table->text('benefits')->nullable();

            $table->string('education')->nullable();

            $table->string('skills')->nullable();

            $table->date('expiry_date')->nullable();

            $table->boolean('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
