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
        Schema::create('login_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('branch_id')->constrained()->nullable();
            $table->string('ip_address', 25)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('country', 25)->nullable();
            $table->string('region', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('zipcode', 25)->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->string('login_session_id', 150)->unique()->nullable();
            $table->timestamp('logged_in_at')->nullable();
            $table->timestamp('logged_out_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_logs');
    }
};
