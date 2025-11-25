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
        Schema::create('camp_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('camp_id')->constrained()->onDelete('cascade');
            $table->dateTime('registration_date')->nullable();
            $table->string('name', 50);
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->smallInteger('age');
            $table->string('mobile', 10)->nullable();
            $table->string('address')->nullable();
            $table->string('notes')->nullable();
            $table->unsignedBigInteger('registration_id')->nullable();
            $table->foreignId('created_by')->constrained('users', 'id');
            $table->foreignId('updated_by')->constrained('users', 'id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camp_details');
    }
};
