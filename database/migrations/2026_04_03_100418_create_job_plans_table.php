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
        Schema::create('job_plans', function (Blueprint $table) {
            $table->id();
             $table->string('name');
            $table->integer('duration_days');
            $table->decimal('price', 8, 2);
            $table->decimal('gst_amount', 8, 2);
            $table->decimal('total_price', 8, 2);
            $table->integer('job_post_limit')->default(1);

            $table->boolean('applicant_management')->default(true);
            $table->boolean('email_notifications')->default(true);
            $table->boolean('tamil_nadu_reach')->default(true);
            $table->boolean('featured_listing')->default(false);
            $table->boolean('priority_support')->default(false);
            
            $table->integer('status')->default(1);

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_plans');
    }
};
