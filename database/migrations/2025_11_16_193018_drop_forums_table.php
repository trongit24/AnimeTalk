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
        // Drop forum_tag pivot table first
        Schema::dropIfExists('forum_tag');
        
        // Drop foreign key from posts table if exists
        if (Schema::hasColumn('posts', 'forum_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropForeign(['forum_id']);
                $table->dropColumn('forum_id');
            });
        }
        
        // Then drop forums table
        Schema::dropIfExists('forums');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot recreate table automatically
    }
};
