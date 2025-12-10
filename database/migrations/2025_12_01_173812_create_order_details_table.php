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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('eye', 10)->nullable();
            $table->string('sph', 7)->nullable();
            $table->string('cyl', 7)->nullable();
            $table->string('axis', 7)->nullable();
            $table->string('addition', 7)->nullable();
            $table->string('dia', 7)->nullable();
            $table->foreignId('thick')->constrained('extras', 'id')->nullable();
            $table->string('ipd', 7)->nullable();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('qty')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->decimal('total', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
