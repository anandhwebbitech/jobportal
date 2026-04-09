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
        Schema::create('banner_plans', function (Blueprint $table) {
            $table->id();
            // 📌 Plan Info
            $table->string('name'); // e.g. Home Page Banner
            $table->string('placement')->nullable(); // Home / Sidebar

            // 💰 Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('gst_amount', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2);

            // ⏱ Duration
            $table->integer('duration_days'); // e.g. 10 days

            // ⚙️ Features (store multiple)
            $table->json('features')->nullable();

            // 🔄 Status
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_plans');
    }
};
