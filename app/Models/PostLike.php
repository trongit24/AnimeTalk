<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PostLike extends Model
{
    protected $fillable = ['user_id', 'post_id', 'likeable_id', 'likeable_type'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'uid');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }
}
