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
        Schema::create('user_plan_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_plan_id')->constrained()->onDelete('cascade');

            $table->dateTime('start_date');
            $table->dateTime('end_date');

            $table->integer('jobs_used')->default(0);
            $table->integer('job_post_limit');

            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');

            $table->string('payment_id')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_plan_subscriptions');
    }
};
