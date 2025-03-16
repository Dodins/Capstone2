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
    Schema::create('residents', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('full_name');
        $table->enum('gender', ['male', 'female']);
        $table->string('phone_number');
        $table->string('address');
        $table->date('date_of_birth');
        $table->string('emergency_contact_name');
        $table->string('emergency_contact_number');
        $table->string('relationship');
        $table->string('barangay_id_image')->nullable();
        $table->boolean('is_verified')->default(false);
        $table->enum('application_status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->timestamps();
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
