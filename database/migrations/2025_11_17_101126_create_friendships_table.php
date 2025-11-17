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
        Schema::create('friendships', function (Blueprint $table) {
            $table->id();
            $table->string('user_id'); // uid người gửi lời mời
            $table->string('friend_id'); // uid người nhận lời mời
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('uid')->on('users')->onDelete('cascade');
            $table->foreign('friend_id')->references('uid')->on('users')->onDelete('cascade');
            
            // Đảm bảo không gửi trùng lặp
            $table->unique(['user_id', 'friend_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friendships');
    }
};
