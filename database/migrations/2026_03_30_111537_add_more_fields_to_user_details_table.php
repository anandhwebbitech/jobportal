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
        Schema::table('user_details', function (Blueprint $table) {
            //
            $table->date('dob')->nullable()->after('mobile');
            $table->string('gender')->nullable()->after('dob');
            $table->text('bio')->nullable()->after('gender');

            $table->string('last_salary')->nullable()->after('exp');

            $table->string('institution_name')->nullable()->after('last_salary');
            $table->string('course_degree')->nullable()->after('institution_name');
            $table->string('specialization')->nullable()->after('course_degree');
            $table->year('year_of_passing')->nullable()->after('specialization');
            $table->string('percentage')->nullable()->after('year_of_passing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            //
        });
    }
};
