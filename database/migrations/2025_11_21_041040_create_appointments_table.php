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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->smallInteger('age');
            $table->string('address')->nullable();
            $table->string('mobile', 10)->nullable();
            $table->string('email', 100)->nullable();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->date('adate')->nullable();
            $table->time('atime')->nullable();
            $table->unsignedBigInteger('old_mrn')->nullable();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users', 'id');
            $table->foreignId('updated_by')->constrained('users', 'id');
            $table->unique(['doctor_id', 'adate', 'atime', 'branch_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
