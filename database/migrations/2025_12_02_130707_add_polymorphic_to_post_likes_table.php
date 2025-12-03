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
        Schema::table('post_likes', function (Blueprint $table) {
            if (!Schema::hasColumn('post_likes', 'likeable_id')) {
                $table->unsignedBigInteger('likeable_id')->nullable()->after('post_id');
            }
            if (!Schema::hasColumn('post_likes', 'likeable_type')) {
                $table->string('likeable_type')->nullable()->after('likeable_id');
            }
        });
        
        // Update existing likes to use polymorphic
        \DB::statement("UPDATE post_likes SET likeable_id = post_id, likeable_type = 'App\\\\Models\\\\Post' WHERE post_id IS NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_likes', function (Blueprint $table) {
            $table->dropColumn(['likeable_id', 'likeable_type']);
        });
    }
};
