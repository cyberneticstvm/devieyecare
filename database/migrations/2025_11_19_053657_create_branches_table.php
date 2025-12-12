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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('code', 10)->unique();
            $table->string('gstin', 25)->nullable();
            $table->text('address')->nullable();
            $table->string('email', 50)->nullable();
            $table->string('contact', 25)->nullable();
            $table->integer('display_capacity')->nullable();
            $table->bigInteger('invoice_starts_with')->nullable();
            $table->decimal('daily_expense_limit', 10, 2)->default(0);
            $table->boolean('is_store')->comment('Store / Stock for purchase')->default(0);
            $table->foreignId('created_by')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('updated_by')->constrained('users', 'id')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
