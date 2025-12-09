<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Event;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('slug')->unique()->nullable()->after('title');
        });

        // Tạo slug cho các events hiện có
        Event::chunk(100, function ($events) {
            foreach ($events as $event) {
                $event->slug = Str::slug($event->title) . '-' . uniqid();
                $event->save();
            }
        });

        // Sau khi tạo slug xong, chuyển cột thành NOT NULL
        Schema::table('events', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
