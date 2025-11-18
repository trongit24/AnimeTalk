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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('user_id'); // Event creator (owner)
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('cover_image')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->enum('privacy', ['public', 'private', 'friends'])->default('public');
            $table->integer('participants_count')->default(0);
            $table->timestamps();
            
            $table->foreign('user_id')->references('uid')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
