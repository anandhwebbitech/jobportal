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
        Schema::table('jobs', function (Blueprint $table) {
            //
            $table->string('category')->nullable()->after('title');
            $table->string('industry')->nullable()->after('category');
            $table->string('num_vacancies')->nullable()->after('industry');
            $table->string('message')->nullable()->after('num_vacancies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            //
            $table->dropColumn([
                'category',
                'industry',
                'num_vacancies',
                'message'
            ]);
        });
    }
};
