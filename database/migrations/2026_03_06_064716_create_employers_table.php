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
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('owner_name');
            $table->string('email')->unique();

            $table->string('contact_number');
            $table->enum('contact_type',['Owner','HR','Recruiter']);
            $table->string('alternate_contact_number')->nullable();

            $table->text('address')->nullable();

            $table->string('gst_number')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('proof_document')->nullable();

            $table->enum('status',['pending','approved','rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};
