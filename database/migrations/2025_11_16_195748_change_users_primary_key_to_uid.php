<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop foreign keys first
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        Schema::table('post_likes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        Schema::table('communities', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        Schema::table('community_members', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        // Add uid column to users
        Schema::table('users', function (Blueprint $table) {
            $table->string('uid', 20)->unique()->after('id');
        });
        
        // Generate UIDs for existing users
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            DB::table('users')->where('id', $user->id)
                ->update(['uid' => 'U' . str_pad($user->id, 10, '0', STR_PAD_LEFT)]);
        }
        
        // Remove auto_increment from id column first
        DB::statement('ALTER TABLE users MODIFY id BIGINT UNSIGNED NOT NULL');
        
        // Drop old id primary key and set uid as primary
        Schema::table('users', function (Blueprint $table) {
            $table->dropPrimary(['id']);
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->primary('uid');
        });
        
        // Store old user_id values temporarily
        DB::statement('ALTER TABLE posts ADD COLUMN old_user_id BIGINT UNSIGNED');
        DB::statement('UPDATE posts SET old_user_id = user_id');
        
        DB::statement('ALTER TABLE comments ADD COLUMN old_user_id BIGINT UNSIGNED');
        DB::statement('UPDATE comments SET old_user_id = user_id');
        
        DB::statement('ALTER TABLE post_likes ADD COLUMN old_user_id BIGINT UNSIGNED');
        DB::statement('UPDATE post_likes SET old_user_id = user_id');
        
        DB::statement('ALTER TABLE communities ADD COLUMN old_user_id BIGINT UNSIGNED');
        DB::statement('UPDATE communities SET old_user_id = user_id');
        
        DB::statement('ALTER TABLE community_members ADD COLUMN old_user_id BIGINT UNSIGNED');
        DB::statement('UPDATE community_members SET old_user_id = user_id');
        
        // Update foreign key columns to string
        Schema::table('posts', function (Blueprint $table) {
            $table->string('user_id', 20)->change();
        });
        
        Schema::table('comments', function (Blueprint $table) {
            $table->string('user_id', 20)->change();
        });
        
        Schema::table('post_likes', function (Blueprint $table) {
            $table->string('user_id', 20)->change();
        });
        
        Schema::table('communities', function (Blueprint $table) {
            $table->string('user_id', 20)->change();
        });
        
        Schema::table('community_members', function (Blueprint $table) {
            $table->string('user_id', 20)->change();
        });
        
        // Update foreign key values to match UIDs
        DB::statement("UPDATE posts p INNER JOIN users u ON p.old_user_id = u.id SET p.user_id = u.uid");
        DB::statement("UPDATE comments c INNER JOIN users u ON c.old_user_id = u.id SET c.user_id = u.uid");
        DB::statement("UPDATE post_likes pl INNER JOIN users u ON pl.old_user_id = u.id SET pl.user_id = u.uid");
        DB::statement("UPDATE communities co INNER JOIN users u ON co.old_user_id = u.id SET co.user_id = u.uid");
        DB::statement("UPDATE community_members cm INNER JOIN users u ON cm.old_user_id = u.id SET cm.user_id = u.uid");
        
        // Drop old_user_id columns
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('old_user_id');
        });
        
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('old_user_id');
        });
        
        Schema::table('post_likes', function (Blueprint $table) {
            $table->dropColumn('old_user_id');
        });
        
        Schema::table('communities', function (Blueprint $table) {
            $table->dropColumn('old_user_id');
        });
        
        Schema::table('community_members', function (Blueprint $table) {
            $table->dropColumn('old_user_id');
        });
        
        // Drop old id column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id');
        });
        
        // Re-add foreign keys
        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('user_id')->references('uid')->on('users')->onDelete('cascade');
        });
        
        Schema::table('comments', function (Blueprint $table) {
            $table->foreign('user_id')->references('uid')->on('users')->onDelete('cascade');
        });
        
        Schema::table('post_likes', function (Blueprint $table) {
            $table->foreign('user_id')->references('uid')->on('users')->onDelete('cascade');
        });
        
        Schema::table('communities', function (Blueprint $table) {
            $table->foreign('user_id')->references('uid')->on('users')->onDelete('cascade');
        });
        
        Schema::table('community_members', function (Blueprint $table) {
            $table->foreign('user_id')->references('uid')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the process (restore id as primary key)
        // Drop foreign keys
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        Schema::table('post_likes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        Schema::table('communities', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        Schema::table('community_members', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        // Add back id column
        Schema::table('users', function (Blueprint $table) {
            $table->dropPrimary(['uid']);
            $table->id()->first();
        });
        
        // Drop uid column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('uid');
        });
        
        // Change foreign keys back to bigInteger
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::table('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::table('post_likes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::table('communities', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::table('community_members', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
