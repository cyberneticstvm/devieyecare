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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mrn')->unique();
            $table->string('name', 50);
            $table->smallInteger('age');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('address')->nullable();
            $table->string('mobile', 10)->nullable();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('rtype')->comment("Registration Type such as New / Review / Camp / Appointment")->constrained('extras', 'id')->onDelete('cascade');
            $table->unsignedBigInteger('rtype_id')->comment("Appointment Id or Camp Id or Old MRN")->nullable();
            $table->foreignId('ctype')->comment("Consultation type such as Certificate / Surgery / Consultation")->constrained('extras', 'id')->onDelete('cascade');
            $table->decimal('doc_fee', 7, 2)->default(0);
            $table->unsignedBigInteger('doc_fee_pmode')->nullable();
            $table->boolean('surgery_advised')->default(false);
            $table->date('post_review_date')->nullable();
            $table->foreignId('status')->comment("RGSTD / CNLT")->constrained('extras', 'id')->onDelete('cascade');
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
        Schema::dropIfExists('registrations');
    }
};
