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
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->string('iop', 10)->nullable();
            $table->string('bs', 10)->nullable();
            $table->string('bp', 10)->nullable();
            $table->boolean('allergic')->default(0);
            $table->longText('history')->nullable();
            $table->longText('re_co')->nullable();
            $table->longText('le_co')->nullable();
            $table->longText('diagnosis')->nullable();
            $table->longText('treatment')->nullable();
            $table->string('ipd', 10)->nullable();
            $table->boolean('dct')->default(0);
            $table->boolean('ic')->default(0);
            $table->boolean('suture')->default(0);
            $table->longText('remarks')->nullable();
            $table->string('re_vision', 10)->nullable();
            $table->string('re_dv', 10)->nullable();
            $table->string('re_nv', 10)->nullable();
            $table->string('le_vision', 10)->nullable();
            $table->string('le_dv', 10)->nullable();
            $table->string('le_nv', 10)->nullable();
            $table->string('re_arm1', 10)->nullable();
            $table->string('re_arm2', 10)->nullable();
            $table->string('re_arm3', 10)->nullable();
            $table->string('le_arm1', 10)->nullable();
            $table->string('le_arm2', 10)->nullable();
            $table->string('le_arm3', 10)->nullable();
            $table->string('re_sph', 10)->nullable();
            $table->string('re_cyl', 10)->nullable();
            $table->string('re_axis', 10)->nullable();
            $table->string('re_add', 10)->nullable();
            $table->string('le_sph', 10)->nullable();
            $table->string('le_cyl', 10)->nullable();
            $table->string('le_axis', 10)->nullable();
            $table->string('le_add', 10)->nullable();
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
        Schema::dropIfExists('procedures');
    }
};
