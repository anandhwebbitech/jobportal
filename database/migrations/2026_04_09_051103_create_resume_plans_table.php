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
        Schema::create('resume_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Silver, Gold, Platinum
            $table->decimal('price', 10, 2);          // Base price
            $table->decimal('gst_amount', 10, 2)->default(0); 
            $table->decimal('total_price', 10, 2);  

            $table->integer('downloads_limit'); // e.g. 100, 200
            $table->integer('valid_days'); // e.g. 30, 60

            $table->json('features')->nullable(); // optional

            $table->boolean('status')->default(1); // active/inactive
            $table->boolean('is_active')->default(1); // for UI toggle

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_plans');
    }
};
