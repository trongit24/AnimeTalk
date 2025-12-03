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
        Schema::create('community_memories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id')->constrained('communities')->onDelete('cascade');
            $table->string('user_id', 20);
            $table->foreign('user_id')->references('uid')->on('users')->onDelete('cascade');
            $table->string('image'); // Required: Photo from camera
            $table->text('caption')->nullable(); // Optional caption
            $table->timestamps();
            
            $table->index(['community_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_memories');
    }
};
