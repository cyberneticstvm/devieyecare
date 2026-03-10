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
        Schema::create('rx_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->string("type", 10)->nullable();
            $table->string("eye", 10)->nullable();
            $table->string('sph', 7)->nullable();
            $table->string('cyl', 7)->nullable();
            $table->string('axis', 7)->nullable();
            $table->string('addition', 7)->nullable();
            $table->integer('qty')->nullable();
            $table->string("location", 50)->nullable();
            $table->unsignedBigInteger("from_branch")->nullable();
            $table->unsignedBigInteger("to_branch")->nullable();
            $table->string("transaction_type", 10)->nullable();
            $table->unsignedBigInteger("transaction_type_id")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rx_stocks');
    }
};
