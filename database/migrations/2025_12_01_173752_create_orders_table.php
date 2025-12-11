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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('invoice_number')->nullable();
            $table->timestamp('invoice_generated_at')->nullable();
            $table->foreignId('invoice_generated_by')->constrained('users', 'id');
            $table->decimal('discount', 8, 2)->default(0);
            $table->decimal('total', 8, 2)->comment('After Discount')->default(0);
            $table->decimal('advance', 8, 2)->default(0);
            $table->foreignId('advance_pmode')->constrained('extras', 'id')->nullable();
            $table->date('due_date')->comment('Expected delivery date')->nullable();
            $table->foreignId('product_advisor')->constrained('users', 'id')->onDelete('cascade');
            $table->string('remarks')->nullable();
            $table->foreignId('status')->constrained('extras', 'id')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
