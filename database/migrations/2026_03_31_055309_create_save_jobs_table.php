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
        Schema::create('save_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->timestamp('saved_at')->nullable();
            $table->tinyInteger('status')->default(1); // 1=active, 0=inactive
            $table->tinyInteger('savestatus')->default(1); // 1=saved, 0=unsaved
            $table->tinyInteger('job_status')->default(1);
            $table->timestamps();
            $table->unique(['user_id','job_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('save_jobs');
    }
};
