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
        Schema::create('hsns', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('short_name', 10)->unique();
            $table->string('code', 10)->nullable();
            $table->integer('tax_percentage')->default(0);
            $table->boolean('is_expiry')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hsns');
    }
};
