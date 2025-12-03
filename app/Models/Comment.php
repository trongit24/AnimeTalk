<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'commentable_id',
        'commentable_type',
        'content',
        'image',
        'likes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'uid');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function isOwnedBy($user)
    {
        if (!$user) return false;
        return $this->user_id === $user->uid;
    }
}
