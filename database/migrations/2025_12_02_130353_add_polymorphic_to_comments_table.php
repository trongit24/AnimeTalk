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
        Schema::table('comments', function (Blueprint $table) {
            if (!Schema::hasColumn('comments', 'commentable_id')) {
                $table->unsignedBigInteger('commentable_id')->nullable()->after('post_id');
            }
            if (!Schema::hasColumn('comments', 'commentable_type')) {
                $table->string('commentable_type')->nullable()->after('commentable_id');
            }
        });
        
        // Update existing comments to use polymorphic
        \DB::statement("UPDATE comments SET commentable_id = post_id, commentable_type = 'App\\\\Models\\\\Post' WHERE post_id IS NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['commentable_id', 'commentable_type']);
        });
    }
};
