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
        Schema::create('concern_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('concern_id')->constrained();
            $table->string('notes');
            $table->string('img_proof')->nullable();
            $table->string('auto_message');
            $table->enum('status', ['new', 'under_review', 'pending_action', 'resolved', 'completed', 'rejected']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concern_status_histories');
    }
};
