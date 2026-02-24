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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->integer("consultation_fee_waived_days")->default(0);
            $table->integer("consultation_fee_waived_days_for_surgery")->default(0);
            $table->decimal("vehicle_fee_per_month", 5, 2)->default(0);
            $table->time("user_login_allowed_time_from")->nullable();
            $table->time("user_login_allowed_time_to")->nullable();
            $table->time("user_active_time_from")->nullable();
            $table->time("user_active_time_to")->nullable();
            $table->decimal("pdct_advisor_commission_level", 10, 2)->default(0);
            $table->decimal("invoice_due_amount_limit", 10, 2)->default(0);
            $table->integer("invoice_due_count_limit")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
