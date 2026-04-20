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
        Schema::create('banner_plan_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('banner_plan_id')->constrained('banner_plans')->cascadeOnDelete();

            $table->string('banner_image')->nullable(); // uploaded banner

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->decimal('price', 10, 2);
            $table->decimal('gst_amount', 10, 2);
            $table->decimal('total_price', 10, 2);

            $table->enum('status', ['pending', 'active', 'expired'])->default('pending');

            $table->string('payment_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_plan_subscriptions');
    }
};
