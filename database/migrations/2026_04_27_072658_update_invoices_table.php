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
        //
        Schema::table('invoices', function (Blueprint $table) {

            $table->string('plan_type')->nullable()->after('plan_id');
            $table->string('plan_name')->nullable()->after('plan_type');

            $table->string('payment_id')->nullable()->after('payment_method');

            $table->decimal('gst_amount', 10, 2)->default(0)->after('amount');
            $table->decimal('total_amount', 10, 2)->default(0)->after('gst_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
