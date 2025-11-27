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
        Schema::create('vehicle_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 7, 2)->default(0);
            $table->date('pdate')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('vehicle_payments');
    }
};
