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
        Schema::create('concerns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('location');
            $table->text('description');
            $table->string('evidence');
            $table->enum('status', ['new', 'under_review', 'pending_action', 'resolved', 'completed', 'rejected'])->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->nullable();
            $table->enum('resident_confirmation', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concerns');
    }
};
