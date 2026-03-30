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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            // 🔗 Relation
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 📄 Resume Details
            $table->string('file_path');       // storage path
            $table->string('file_name');       // original name
            $table->string('title')->nullable();

            // 📊 Extra Info
            $table->string('file_type')->nullable(); // pdf/doc/docx
            $table->integer('file_size')->nullable(); // bytes

            // ⭐ Features
            $table->boolean('is_default')->default(false); // primary resume
            $table->boolean('is_active')->default(true);   // visibility

            // ⏱️ Timestamps
            $table->timestamp('uploaded_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
