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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable(); // null = thông báo cho tất cả
            $table->string('type'); // friend_request, event_reminder, event_starting, admin_announcement, system_maintenance
            $table->string('title');
            $table->text('message');
            $table->text('data')->nullable(); // JSON data (event_id, friend_id, etc.)
            $table->string('action_url')->nullable(); // Link để redirect
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('uid')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'is_read', 'created_at']);
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
