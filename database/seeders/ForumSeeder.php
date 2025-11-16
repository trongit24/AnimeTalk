<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert Tags
        $tags = [
            ['name' => 'Anime', 'slug' => 'anime', 'color' => '#A8C5E8', 'description' => 'Discussions about anime series and movies'],
            ['name' => 'Manga', 'slug' => 'manga', 'color' => '#F4A8B3', 'description' => 'Manga reading and recommendations'],
            ['name' => 'Cosplay', 'slug' => 'cosplay', 'color' => '#C8B8E8', 'description' => 'Cosplay events and costumes'],
            ['name' => 'Gaming', 'slug' => 'gaming', 'color' => '#B8E8D8', 'description' => 'Anime-related games and gaming discussions'],
            ['name' => 'Art', 'slug' => 'art', 'color' => '#F8D8B8', 'description' => 'Fan art and artistic creations'],
            ['name' => 'Discussion', 'slug' => 'discussion', 'color' => '#D8C8F8', 'description' => 'General anime discussions'],
        ];

        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'name' => $tag['name'],
                'slug' => $tag['slug'],
                'color' => $tag['color'],
                'description' => $tag['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Insert Forums
        $forums = [
            ['name' => 'Anime Discussion', 'slug' => 'anime-discussion', 'description' => 'Talk about your favorite anime series', 'icon' => '🎬'],
            ['name' => 'Manga Corner', 'slug' => 'manga-corner', 'description' => 'Manga recommendations and discussions', 'icon' => '📚'],
            ['name' => 'Cosplay Central', 'slug' => 'cosplay-central', 'description' => 'Share your cosplay photos and tips', 'icon' => '👘'],
            ['name' => 'Fan Art Gallery', 'slug' => 'fan-art-gallery', 'description' => 'Show off your anime fan art', 'icon' => '🎨'],
            ['name' => 'Anime News', 'slug' => 'anime-news', 'description' => 'Latest anime industry news', 'icon' => '📰'],
        ];

        foreach ($forums as $forum) {
            DB::table('forums')->insert([
                'name' => $forum['name'],
                'slug' => $forum['slug'],
                'description' => $forum['description'],
                'icon' => $forum['icon'],
                'post_count' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Link Forums with Tags
        $forumTags = [
            [1, 1], // Anime Discussion -> Anime
            [1, 6], // Anime Discussion -> Discussion
            [2, 2], // Manga Corner -> Manga
            [3, 3], // Cosplay Central -> Cosplay
            [4, 5], // Fan Art Gallery -> Art
            [5, 1], // Anime News -> Anime
        ];

        foreach ($forumTags as $link) {
            DB::table('forum_tag')->insert([
                'forum_id' => $link[0],
                'tag_id' => $link[1],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
