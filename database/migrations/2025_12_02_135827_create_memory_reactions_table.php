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
        Schema::create('memory_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memory_id')->constrained('community_memories')->onDelete('cascade');
            $table->string('user_id', 20);
            $table->foreign('user_id')->references('uid')->on('users')->onDelete('cascade');
            $table->string('reaction'); // Emoji: ❤️, 😂, 😮, 😢, 👍, 🔥, etc.
            $table->timestamps();
            
            $table->unique(['memory_id', 'user_id']); // Mỗi user chỉ 1 reaction/memory
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memory_reactions');
    }
};
