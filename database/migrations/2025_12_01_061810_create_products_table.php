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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hsn_id')->constrained()->onDelete('cascade');
            $table->string('name', 100)->unique();
            $table->string('code', 25)->unique();
            $table->string('description')->nullable();
            $table->decimal('selling_price', 8, 2)->default(0);
            $table->foreignId('manufacturer_id')->constrained('manufacturer_suppliers', 'id')->onDelete('cascade');
            $table->integer('default_delivery_days')->default(0);
            $table->boolean('eligible_for_adviser')->default(false);
            $table->unsignedBigInteger("frame_type")->nullable();
            $table->unsignedBigInteger("material")->nullable();
            $table->string("avatar", 15)->nullable();
            $table->string("dia", 10)->nullable();
            $table->string("temple_size", 10)->nullable();
            $table->string("bridge_size", 10)->nullable();
            $table->string("weight", 25)->nullable();
            $table->string("model_name", 50)->nullable();
            $table->unsignedBigInteger("brand")->nullable();
            $table->string("img")->nullable();
            $table->string("img_avatar")->nullable();
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
        Schema::dropIfExists('products');
    }
};
